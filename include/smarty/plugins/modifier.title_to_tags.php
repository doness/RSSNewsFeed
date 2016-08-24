<?php
function smarty_modifier_title_to_tags($title) {
	$tags = explode('-',slugit($title));
		foreach ($tags AS $tag) {
			if (mb_strlen($tag,'UTF-8') > 4) {
			$searchs[] = trim($tag);
			}
		}
	return $searchs;
}

?>