<?php
include('include/autoloader.php');
$smarty->assign('is_home',1); // to use with menu (home select)

// assign the SEO variables (title,keywords,description).	
$smarty->assign('seo_title',$general_setting['seo_title']);	
$smarty->assign('seo_keywords',$general_setting['seo_keywords']);
$smarty->assign('seo_description',$general_setting['seo_description']);
// display the index HTML 
$smarty->display('index.html');
?>