<?php
// sanitize inputs 
function make_safe($str)
{
    global $mysqli;
	$str = $mysqli->real_escape_string($str);
	return strip_tags(trim($str));
}
// get first image in string using html dom
function get_first_image($html){
    if (!empty($html)) {
		
	require_once('simple_html_dom.php');
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

// check if the article exists befor
function check_item_url($permalink,$source_id) {
	global $mysqli;
	$sql = "SELECT permalink,source_id FROM news WHERE permalink='$permalink' AND source_id='$source_id' LIMIT 1";
	$query = $mysqli->query($sql);
	return $query->num_rows;
}

// create notifications
function notification($type,$text) {
return '<div class="alert alert-'.$type.'">'.$text.'</div>';
}

// get category name by ID
function get_category($id) {
global $mysqli;
$sql = "SELECT category FROM categories WHERE id='$id' LIMIT 1";
$query = $mysqli->query($sql);
$row = $query->fetch_assoc();
return $row['category'];
}
// get source title by ID
function get_source($id) {
if ($id == 0) {
return 'Private';	
} else {
global $mysqli;
$sql = "SELECT title FROM sources WHERE id='$id' LIMIT 1";
$query = $mysqli->query($sql);
$row = $query->fetch_assoc();
return $row['title'];
}
}
// count news in source
function get_source_news($id) {
global $mysqli;
$sql = "SELECT source_id FROM news WHERE source_id='$id'";
$query = $mysqli->query($sql);
$number = $query->num_rows;
return $number;
}
// count news in category
function get_category_news($id) {
global $mysqli;
$sql = "SELECT category_id FROM news WHERE category_id='$id'";
$query = $mysqli->query($sql);
$number = $query->num_rows;
return $number;
}
// count sources in category
function get_category_sources($id) {
global $mysqli;
$sql = "SELECT category_id FROM sources WHERE category_id='$id'";
$query = $mysqli->query($sql);
$number = $query->num_rows;
return $number;
}

// protect against XSS
function xss_clean($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
}


// empty smarty template cache files	
function empty_templates_cache($str){
         if(is_file($str)){
             return @unlink($str);
         }
         elseif(is_dir($str)){
             $scan = glob(rtrim($str,'/').'/*');
             foreach($scan as $index=>$path){
			 if (str_replace($str,'',$path) === 'index.html') continue;
                 empty_templates_cache($path);
             }
         return true;
		 }
}

// generate month and years select for news statistics
function generate_statics_select($year,$month) {
	$result = '';
	if ($year == date('Y')) {
	$result .= '<optgroup label="'.$year.'">';
	for($i=$month;$i<date('n')+1;$i++) {
	$result .= '<option value="?year='.$year.'&month='.$i.'">'.month_name($i).'</option>';
	}	
	$result .= '</optgroup>';
	} else {
	$result .= '<optgroup label="'.$year.'">';
	for($i=$month;$i<13;$i++) {
	$result .= '<option value="?year='.$year.'&month='.$i.'">'.month_name($i).'</option>';
	}	
	$result .= '</optgroup>';
	for($y=$year+1;$y<date('Y')+1;$y++) {
	$result .= '<optgroup label="'.$y.'">';
	for($m=1;$m<13;$m++) {
	$result .= '<option value="?year='.$y.'&month='.$m.'">'.month_name($m).'</option>';
	if ($y == date('Y') AND $m == date('n')) {
		break;
	}
	}	
	$result .= '</optgroup>';	
	}
	}
return $result;	
}

// convert month number to name
function month_name($month) {
$month_lang = array(
1 => 'January',
2 => 'February',
3 => 'March',
4 => 'April',
5 => 'May',
6 => 'June',
7 => 'July',
8 => 'August',
9 => 'September',
10 => 'October',
11 => 'November',
12 => 'December'
);
return $month_lang[$month];
}
?>