<?php
include('include/autoloader.php');
$smarty->assign('is_search',1);
// fetch the url to get the page id
$ur = explode('?',curPageURL());
if (count($ur) != 0) {
if (isset($ur[1])) {
parse_str($ur[1],$query);	
}
}
	$q = make_safe(xss_clean(htmlspecialchars($query['q'],ENT_QUOTES)));
	$smarty->assign('q',$q);
	// check if the query string is not empty
	if (!empty($q)) {
	$page = 1; // first page number
	$size = $theme_setting['search_news_number']; // number of news per category page you can change it from theme setting
	if (isset($query['page'])){ $page = make_safe(xss_clean(intval($query['page']))); }
	// count news number query
	$sqls = "SELECT * FROM news WHERE published='1' AND title LIKE '%$q%'";
	$qu = $mysqli->query($sqls);
	$total_records = $qu->num_rows;
	$smarty->assign('total_records',$total_records);
	if ($total_records > 0) {
	// define the pagination class. found at : include/pagination.php 	
	$pagination = new Pagination();
	$pagination->setLink("./search/?q=$q&page=%s"); // the link of each page (%s) represent the page number variable
	$pagination->setPage($page);
	$pagination->setSize($size);
	$pagination->setTotalRecords($total_records);
	$get = "SELECT * FROM news WHERE published='1' AND title LIKE '%$q%' ORDER BY id DESC ".$pagination->getLimitSql();
	$q = $mysqli->query($get);
	while ($row = $q->fetch_assoc()) {
	$news[] = $row;
	}
	$smarty->assign('news',$news);
	$pagi = $pagination->create_links();
	$smarty->assign('pagi',$pagi);
	}
	}

// assign the SEO variables (title,keywords,description).	
$smarty->assign('seo_title','Search Results for '.$query['q']);	
$smarty->assign('seo_keywords',$general_setting['seo_keywords']);
$smarty->assign('seo_description',$general_setting['seo_description']);
// display the search HTML 
$smarty->display('search.html');
?>