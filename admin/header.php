<?php
session_start();
// check if the admin is logged, if not redirect it to login page
if(!isset($_SESSION['rss_script_admin'])) {
header("location:login.php");
}
error_reporting(E_ALL); // hide notices and warnings and show only the real errors
// include database connection files and other neccessary classes and functions.
include("../include/config.php");
include("../include/connect.php");
include("include/functions.php");
include("include/setting.php");
include("include/general.class.php");
include("include/upload.class.php");
include("include/pagination.php");
// define the general class
$general = new General;
$general->set_connection($mysqli);
// fetch the current url to get the page name
$parts = Explode('/', $_SERVER["PHP_SELF"]);
$currenttab = $parts[count($parts) - 1];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
    <title>RSS News | Dashboard</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link href="http://fonts.googleapis.com/css?family=Titillium+Web:700" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="assets/css/jasny-bootstrap.min.css">
	<link href="assets/js/plugins/morris/morris.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jasny-bootstrap.min.js"></script>
	<script src="assets/js/jquery_checkall.js"></script>
	<script src="assets/js/plugins/morris/raphael.min.js"></script>
	<script src="assets/js/plugins/morris/morris.min.js"></script>
	<script src="assets/js/plugins/tinymce/tinymce.min.js"></script>
	<script src="assets/js/plugins/tinymce/tinymce-function.js"></script>
	<script src="assets/js/functions.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./"><span class="fa fa-rss"></span> <span class="mini-brand">RSS</span> News</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li <?php if ($currenttab == 'index.php') { ?>class="active"<?php } ?>><a href="index.php"><span class="fa fa-dashboard"></span> Index</a></li>
                    <li <?php if ($currenttab == 'categories.php') { ?>class="active"<?php } ?>><a href="categories.php"><span class="fa fa-reorder"></span> Categories</a></li>
                    <li <?php if ($currenttab == 'sources.php') { ?>class="active"<?php } ?>><a href="sources.php"><span class="fa fa-rss"></span> Sources</a></li>
					<li <?php if ($currenttab == 'news.php') { ?>class="active"<?php } ?>><a href="news.php"><span class="fa fa-newspaper-o"></span> News</a></li>
					<li <?php if ($currenttab == 'links.php') { ?>class="active"<?php } ?>><a href="links.php"><span class="fa fa-link"></span> Links</a></li>
					<li <?php if ($currenttab == 'pages.php') { ?>class="active"<?php } ?>><a href="pages.php"><span class="fa fa-file"></span> Pages</a></li>
					<li class="dropdown">
					  <a href="javascript:void();" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cogs"></span> Setting <b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li><a href="setting.php">General Setting</a></li>
						<li><a href="setting.php?case=theme">Theme Setting</a></li>
						<li class="divider"></li>
						<li><a href="setting.php?case=clear_cache">Clear Cache</a></li>
						<li><a href="setting.php?case=optimize_database">Optimize Database</a></li>
						<li class="divider"></li>
						<li><a href="setting.php?case=remove_old_news">Remove Old News</a></li>
					  </ul>
					</li>
                </ul>
				<ul class="nav navbar-nav navbar-right">
					<li <?php if ($currenttab == 'change_password.php') { ?>class="active"<?php } ?>><a href="change_password.php"><span class="fa fa-lock"></span> Change Password</a></li>
					<li><a href="javascript:ConfirmLogOut();">Logout</a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>
<div class="container">
