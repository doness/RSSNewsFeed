<?php
header("Content-type: text/html; charset=utf8");
set_time_limit(60000*60);
error_reporting(E_ERROR);
include('include/config.php');
include('include/connect.php');
include('include/functions.php');
include('include/setting.php');
// get first image url from sting using HTML dom
function get_first_image($html){
	if (!empty($html)) {
    require_once('include/simple_html_dom.php');
    $post_dom = str_get_html($html);
    $first_img = $post_dom->find('img', 0);
    if($first_img !== null) {
	$image = $first_img->src;
	if (strtok($image, '?') != '') {
	$image = strtok($image, '?');
	} else {
	$image = $image;
	}
        return $image;
    }

    return null;
	} else {
	return null;	
	}
}


// check if the article exists before
function check_item_url($permalink,$source_id) {
	global $mysqli;
	$sql = "SELECT permalink,source_id FROM news WHERE permalink='$permalink' AND source_id='$source_id' LIMIT 1";
	$query = $mysqli->query($sql);
	return $query->num_rows;
}

require_once('include/simplepie.inc');
	$sql = "SELECT * FROM sources WHERE auto_update='1' ORDER BY id ASC";
	$query = $mysqli->query($sql);
	while ($row = $query->fetch_assoc()) {
	$category_id = $row['category_id'];
	$source_id = $row['id'];
	$rss_link = $row['rss_link'];
	$news_number = $row['news_number'];
	$day = date('j');
	$month = date('n');
	$year = date('Y');
		$feed = new SimplePie();
		$feed->set_useragent();
		$feed->set_feed_url($rss_link);
		$feed->strip_htmltags(false);
		$feed->force_feed(true);
		$feed->init(); 
		$feed->handle_content_type();
		$array = array_reverse($feed->get_items(0,$news_number));
			foreach ($array AS $item) {
				$link = $item->get_permalink();
				if (strpos($link,'feedproxy') != false) {
				$orig = $item->get_item_tags('http://rssnamespace.org/feedburner/ext/1.0','origLink');
				$permalink = $orig[0]['data'];
				} else {
				$permalink = $link;
				}
				$title = htmlspecialchars($item->get_title(), ENT_QUOTES);
				if (mb_strlen(strip_tags($item->get_content()),'UTF-8') > mb_strlen(strip_tags($item->get_description()),'UTF-8')) {
				$details = htmlspecialchars($item->get_content(), ENT_QUOTES);					
				} else {
				$details = htmlspecialchars($item->get_description(), ENT_QUOTES);
				}
				$datetime = time();
				if (check_item_url($permalink,$source_id) == 0) {
				if ($enclosure = $item->get_enclosure())
				{
				$image = $enclosure->get_link();
				if (empty($image)) {
				$image = get_first_image($item->get_content());
				if (empty($image)) {
				$image = get_first_image($item->get_description());
				}
				} else {
				$image = $enclosure->get_link();
				}
				} else {
				$image = get_first_image($item->get_content());
				if (empty($image)) {
				$image = get_first_image($item->get_description());
				}
				}
				if (!empty($image)) {
				$filetype = strtolower(substr(strrchr($image,'.'),1));
				if (!in_array($filetype,array('jpg','jpeg','png','gif'))) {
				$filename = '';	
				} else {
				$filename = 'image_'.time().'_'.rand(0000000,99999999).'.'.$filetype;
				$up = file_put_contents('upload/news/'.$filename,file_get_contents($image));
				$size = filesize('upload/news/'.$filename);
				list($width) = getimagesize('upload/news/'.$filename);
				if(intval($size) >= 1024 AND $width >= 40) {
				$filename = $filename;
				} else {
				unlink('upload/news/'.$filename);
				$filename = '';	
				}
				}
				} else {
				$filename = '';
				}
				$insert = $mysqli->query("INSERT INTO news (title,permalink,category_id,source_id,details,datetime,published,thumbnail,day,month,year) 
													  VALUES ('$title','$permalink','$category_id','$source_id','$details','$datetime','1','$filename','$day','$month','$year')");
				}
			}
	
	$now = time();
	$mysqli->query("UPDATE sources SET latest_activity='$now' WHERE id='$source_id'");
	}