<?php
include('include/autoloader.php');
// recieve the page id and slug variables
$id = intval(make_safe(xss_clean($_GET['id'])));
$slug = make_safe(xss_clean($_GET['slug']));
$page = $general->page($id);
// check if the page exists, if not redirect to error page 
if ($page == 0) {
header('Location:'.$general_setting['siteurl'].'/not-found');	
}
// fetching the result
foreach ($page AS $key=>$value) {
$smarty->assign('page_'.$key,$value);	
}
// assign the SEO variables (title,keywords,description).	
$smarty->assign('seo_title',htmlspecialchars_decode($page['title'],ENT_QUOTES));	
$smarty->assign('seo_keywords',title_to_keywords(htmlspecialchars_decode($page['title'],ENT_QUOTES)));
$smarty->assign('seo_description',mb_substr(make_safe(htmlspecialchars_decode($page['content'],ENT_QUOTES)),0,255,'UTF-8'));
// display the page HTML 
$smarty->display('page.html');
?>