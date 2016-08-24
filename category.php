<?php
include('include/autoloader.php');
// recieve the category id and slug variables
$id = intval(make_safe(xss_clean($_GET['id'])));
$slug = make_safe(xss_clean($_GET['slug']));
$smarty->assign('is_category',1); // to use with menu (selected category)
$category = $general->category($id); // the category method found in include/general.class.php
// check if the category exists, if not redirect to error page 
if ($category == 0) {
header('Location:'.$general_setting['siteurl'].'/not-found');	
}
// fetching the result
foreach ($category AS $key=>$value) {
$smarty->assign('category_'.$key,$value);
}
// fetch the url to get the page id
$ur = explode('?',curPageURL());
if (count($ur) != 0) {
if (isset($ur[1])) {
parse_str($ur[1],$query);	
}
}
	$page = 1; // first page number
	$size = $theme_setting['category_news_number']; // number of news per category page you can change it from theme setting
	if (isset($query['page'])){ $page = (int) $query['page']; }
	// count news number that related to this category
	$sqls = "SELECT * FROM news WHERE published='1' AND category_id='$category[id]'";
	$qu = $mysqli->query($sqls);
	$total_records = $qu->num_rows;
	$smarty->assign('total_records',$total_records);
	if ($total_records > 0) {
	// define the pagination class. found at : include/pagination.php 	
	$pagination = new Pagination();
	$pagination->setLink("./category/$id/$slug?page=%s"); // the link of each page (%s) represent the page number variable
	$pagination->setPage($page);
	$pagination->setSize($size);
	$pagination->setTotalRecords($total_records);
	$get = "SELECT * FROM news WHERE published='1' AND category_id='$category[id]' ORDER BY id DESC ".$pagination->getLimitSql();
	$q = $mysqli->query($get);
	while ($row = $q->fetch_assoc()) {
	$news[] = $row;
	}
	$smarty->assign('news',$news);
	$pagi = $pagination->create_links();
	$smarty->assign('pagi',$pagi);
	}

// assign the SEO variables (title,keywords,description).	
$smarty->assign('seo_title',$category['category']);	
$smarty->assign('seo_keywords',$category['seo_keywords']);
$smarty->assign('seo_description',$category['seo_description']);
// display the category HTML 
$smarty->display('category.html');
?>