<?php
include('include/autoloader.php');

// assign the SEO variables (title,keywords,description).	
$smarty->assign('seo_title','the requested page is not found');	
$smarty->assign('seo_keywords',$general_setting['seo_keywords']);
$smarty->assign('seo_description',$general_setting['seo_description']);
// display the index HTML 
$smarty->display('not-found.html');
?>