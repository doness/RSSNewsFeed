<?php
include('include/autoloader.php');
// recieve the article id and slug variables
$id = intval(make_safe(xss_clean($_GET['id'])));
$slug = make_safe(xss_clean($_GET['slug']));
$smarty->assign('is_article',1);
$article = $general->article($id);
// check if the article exists, if not redirect to error page 
if ($article == 0) {
header('Location:'.$general_setting['siteurl'].'/not-found');	
}
// fetching the result
foreach ($article AS $key=>$value) {
$smarty->assign('article_'.$key,$value);	
}
// related news method found in include/general.class.php
$related = $general->related($article['id'],$article['category_id'],$article['title'],$theme_setting['related_news_number']);
// if there related news then assign them.
if ($related != 0) {
$smarty->assign('related',$related);
}
$url = $general_setting['siteurl']."/news/".$article['id']."/".slugit($article['title']);
$article_url = str_replace(':/','://',str_replace('//','/',($url)));
$smarty->assign('article_url',$article_url);
if (!empty($article['thumbnail'])) {
$thumbnail = $general_setting['siteurl'].'/upload/news/'.$article['thumbnail'];
$thumbnail_url = str_replace(':/','://',str_replace('//','/',($thumbnail)));
$smarty->assign('thumbnail_url',$thumbnail_url);
}
// assign the SEO variables (title,keywords,description).	
$smarty->assign('seo_title',htmlspecialchars_decode($article['title'],ENT_QUOTES));	
$smarty->assign('seo_keywords',title_to_keywords(htmlspecialchars_decode($article['title'],ENT_QUOTES)));
$smarty->assign('seo_description',mb_substr(make_safe(htmlspecialchars_decode($article['details'],ENT_QUOTES)),0,255,'UTF-8'));
// display the article HTML 
$smarty->display('article.html');
?>