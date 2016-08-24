<?php
session_start();
header("Content-type: text/html; charset=utf8");
set_time_limit(60000*60);
error_reporting(E_ERROR);
if(!isset($_SESSION['rss_script_admin'])) {
header("location:login.php");
}
include('../include/config.php');
include('../include/connect.php');
include('include/functions.php');
include('include/setting.php');
include('include/general.class.php');
$general = new General;
$general->set_connection($mysqli);
$case = make_safe(xss_clean($_GET['case']));
$action = make_safe(xss_clean($_POST['action'])); 
// sort categories 
if ($action == "sort_category"){
	$records = $_POST['records'];
	$counter = 1;
	foreach ($records as $record) {
		$sql = "UPDATE categories SET category_order='$counter' WHERE id='$record'";
		$query = $mysqli->query($sql);
		$counter = $counter + 1;	
	}
}
// sort links
if ($action == "sort_links"){
	$records = $_POST['records'];
	$counter = 1;
	foreach ($records as $record) {
		$sql = "UPDATE links SET link_order='$counter' WHERE id='$record'";
		$query = $mysqli->query($sql);
		$counter = $counter + 1;	
	}
}
// sort pages
if ($action == "sort_pages"){
	$records = $_POST['records'];
	$counter = 1;
	foreach ($records as $record) {
		$sql = "UPDATE pages SET page_order='$counter' WHERE id='$record'";
		$query = $mysqli->query($sql);
		$counter = $counter + 1;	
	}
}
// remove article image
if ($action == "remove_image") {
	$id = abs(intval($_POST['id']));
	if (empty($id)) {
	header("location:login.php");
	}
	$sql = "SELECT thumbnail FROM news WHERE id='$id'";
	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc();
	if (file_exists('../upload/news/'.$row['thumbnail'])) {
		@unlink('../upload/news/'.$row['thumbnail']);
	}
	$mysqli->query("UPDATE news SET thumbnail='' WHERE id='$id'");
}
// import news from source
if ($action == "news_grab") {
	require_once('include/simplepie.inc');
	$id = abs(intval($_POST['id']));
	if (empty($id)) {
	header("location:login.php");
	}
	$sql = "SELECT * FROM sources WHERE id='$id' LIMIT 1";
	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc();
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
				$up = file_put_contents('../upload/news/'.$filename,file_get_contents($image));
				$size = filesize('../upload/news/'.$filename);
				list($width) = getimagesize('../upload/news/'.$filename);
				if(intval($size) >= 1024 AND $width >= 40) {
				$filename = $filename;
				} else {
				unlink('../upload/news/'.$filename);
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
	$mysqli->query("UPDATE sources SET latest_activity='$now' WHERE id='$id'");
}
?>