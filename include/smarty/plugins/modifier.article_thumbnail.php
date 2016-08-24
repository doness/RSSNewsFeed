<?php
function smarty_modifier_article_thumbnail($thumbnail,$source_id,$additional_class = false,$lazeload = 0)
{
    global $mysqli;
	if (!empty($thumbnail)) {
	if (file_exists('upload/news/'.$thumbnail)) {
	if ($lazeload == 1) {	
	$thumb = '<img data-src="upload/news/'.$thumbnail.'" class="img-responsive '.$additional_class.'" />';
	} else {
	$thumb = '<img src="upload/news/'.$thumbnail.'" class="img-responsive '.$additional_class.'" />';
	}
	} else {
	$thumb = '';	
	} 
	} else {
	$thumb = '';
	}
	if (!empty($thumb)) {
	return $thumb;
	} else {
	$sql = "SELECT thumbnail FROM sources WHERE id='$source_id'";
	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc();
	if (!empty($row['thumbnail'])) {
	if ($lazeload == 1) {
	return '<img data-src="upload/sources/'.$row['thumbnail'].'" class="img-responsive '.$additional_class.'" />';
	} else {
	return '<img src="upload/sources/'.$row['thumbnail'].'" class="img-responsive '.$additional_class.'" />';	
	}
	} else {
	if ($lazeload == 1) {
	return '<img data-src="upload/noimage.jpg" class="img-responsive '.$additional_class.'" />';
	} else {
	return '<img src="upload/noimage.jpg" class="img-responsive '.$additional_class.'" />';
	}
	}
	}
   
}

?>
