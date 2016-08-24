<?php
// hide the warnings and notices and display only the real errors.
error_reporting(E_ALL);
// include required files
include('config.php');
include('connect.php');
include('functions.php');
include('setting.php');
include('pagination.php');
include('general.class.php');
// check if the script installed
if (!isset($general_setting['installed']) OR $general_setting['installed'] == 0) {
die('You Should Install the Script. <a href="install.php">Go to Installation</a>');	
}
// check if the install.php still exists
if (isset($general_setting['installed']) AND $general_setting['installed'] == 1 AND file_exists('install.php')) {
die('Please Delete the install.php file or rename it for security reasons.');		
}
// define general class and setting
$general = new General;
$general->set_connection($mysqli);
// define smarty templates class and setting
require_once('smarty/Smarty.class.php');
$smarty = new Smarty;
$smarty->compile_dir = 'cache/';
$smarty->template_dir = 'themes/'.$general_setting['site_theme'].'/';
$smarty->force_compile = true;

// setting to fetch and assign to smarty
foreach ($setting_row AS $key=>$value) {
$decode_value = @unserialize($value);
if (!empty($decode_value)) {
foreach ($decode_value AS $key2=>$value2) {
$smarty->assign($key.'_'.$key2,$value2);
}
}
}
// queries that run in all pages
// categories query
$categories = $general->categories('category_order ASC');
$smarty->assign('categories',$categories);
// links query
$links = $general->links('link_order ASC');
$smarty->assign('links',$links);
// pages query
$pages = $general->pages('page_order ASC');
$smarty->assign('pages',$pages);
// top news query
$top = $general->news($general_setting['top_news_period'],'hits DESC',$theme_setting['top_news_number']);
$smarty->assign('top',$top);
// ads blocks
$header_ad = file_get_contents('ads/header.txt');
$smarty->assign('header_ad',$header_ad);
$widget_ad = file_get_contents('ads/widget.txt');
$smarty->assign('widget_ad',$widget_ad);
$content_ad = file_get_contents('ads/content.txt');
$smarty->assign('content_ad',$content_ad);
?>
