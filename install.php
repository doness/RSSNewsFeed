<?php
error_reporting(E_ERROR);
include('include/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Script Charset -->
	<meta charset="UTF-8">
	<!-- Style Viewport for Responsive purpose -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- The Script Base URL -->
		<title>RSS News | Installation</title>
		<!-- CSS Files -->
		<link rel="stylesheet" href="themes/default/css/bootstrap.min.css">
		<link rel="stylesheet" href="themes/default/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="themes/default/css/font-awesome.min.css">
		<link href="http://fonts.googleapis.com/css?family=Titillium+Web:400,700" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="themes/default/css/style.css">
		<!-- Javascript Files -->
		<script src="themes/default/js/jquery.min.js"></script>
		<script src="themes/default/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="container">
	<div class="row">
	<div class="col-md-8 col-md-push-2">
	<div class="logo"><img src="themes/default/images/logo.png" class="img-responsive" /></div>
	<div class="install">
	<?php
	switch ($_GET['do']) {
	case 'create_admin';
	$mysqli = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['name']);
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	// set charset to UTF-8
	$mysqli->set_charset("utf8");
	if (isset($_POST['create'])) {
	$admin = $_POST['admin'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	if (empty($admin)) {
	$message = '<div class="alert alert-warning">Insert The Admin Username Please.</div>';
	} elseif (empty($password)) {
	$message = '<div class="alert alert-warning">Insert The Admin Password Please.</div>';
	} elseif (empty($confirm_password)) {
	$message = '<div class="alert alert-warning">Insert The Admin Password Confirmation Please.</div>';
	} elseif ($password != $confirm_password) {
	$message = '<div class="alert alert-warning">The Password Doesn\'t Match The Confirmation.</div>';
	} else {
	
	$encoded_password = hash('sha256', md5($password));
	$insert = $mysqli->query("INSERT INTO admin (id,username,password) VALUES ('1','$admin','$encoded_password')");
	if ($insert) {
	$message = '<div class="alert alert-success">The Admin Has Been Created Successfully.</div>';
	} else {
	$message = '<div class="alert alert-danger">Error Happened</div>';
	}
	}
	}
	?>
	<div class="content">
	<h4>Create Admin</h4>
	<?php if (isset($message)) {echo $message;} ?>
	<form method="POST" action="">
		<div class="form-group">
			<label for="admin">Admin Username</label>
			<input type="text" class="form-control" name="admin" id="admin" />
		</div>
		<div class="form-group">
			<label for="password">Admin Password</label>
			<input type="password" class="form-control" name="password" id="password" />
		</div>
		<div class="form-group">
			<label for="confirm_password">Admin Password Confirmation</label>
			<input type="password" class="form-control" name="confirm_password" id="confirm_password" />
		</div>
	
	<input type="submit" name="create" value="Save" class="btn btn-success" />
	</form>
	</div>
	<?php 
	$get = $mysqli->query("SELECT * FROM admin WHERE id='1'");
	if ($get->num_rows == 1) {
	?>
	<div class="buttons_div">
	<span class="right"><a href="?do=setting" class="btn btn-primary">Edit Setting</a></span>
	</div>
	<?php
	}
	?>
	<?php
	break;
	case 'setting';
	// mysqli connect method
	$mysqli = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['name']);
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	// set charset to UTF-8
	$mysqli->set_charset("utf8");
	if (isset($_POST['save'])) {
	$all = base64_encode(serialize($_POST));
		$update = $mysqli->query("UPDATE setting SET general='$all' WHERE id='1'");
		if ($update) {
			$message = '<div class="alert alert-success">Setting Saved</div>';
		} else {
			$message = '<div class="alert alert-danger">Error Happened</div>';
		}
		unset($_POST);
		unset($all);
	}
	$get = $mysqli->query("SELECT general FROM setting WHERE id='1'");
	$g = $get->fetch_array();
	$general = unserialize(base64_decode($g['general']));
	function curPageURL() 
	{
	 $pageURL = 'http';
	 if (isset($_SERVER["HTTPS"])) {
	 $https = $_SERVER["HTTPS"]; 
	 }
	 if (isset($https) AND $https == "on") {$pageURL .= "s";} else {$pageURL .= "";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
	?>
	<h4>Setting</h4>
	<div class="install-content">
	<?php if (isset($message)) {echo $message;} ?>
			<form role="form" method="POST" action="">
		  <div class="form-group">
			<label for="siteurl">Site Url</label>
			<input type="text" class="form-control" name="siteurl" id="siteurl" placeholder="http://www.domain.com" value="<?php echo str_replace('/install.php?do=setting','',curPageURL()); ?>" />
			<p class="help">If you place the script in the root folder don't use slash <b>/</b> at the end of site url.</p>
		  </div>
		  <div class="form-group">
			<label for="seo_title">Site Name</label>
			<input type="text" class="form-control" name="seo_title" id="seo_title" placeholder="your site title" value="<?php echo $general['seo_title']; ?>" />
		  </div>
		  
		  <div class="form-group">
			<label for="seo_keywords">SEO Keywords</label>
			<input type="text" class="form-control" name="seo_keywords" id="seo_keywords" placeholder="news,rss,feeds" value="<?php echo $general['seo_keywords']; ?>" />
		  </div>
		  <div class="form-group">
			<label for="seo_description">SEO Description</label>
			<textarea class="form-control" name="seo_description" id="seo_description" rows="3" placeholder="some words about the site .. don't exceed 255 character."><?php echo $general['seo_description']; ?></textarea>
		  </div>
		  <div class="form-group">
			<label for="top_news_period">Top News Period (Days)</label>
			<select name="top_news_period" id="top_news_period" class="form-control">
				<option value="86400" <?php if ($general['top_news_period'] == 86400) {echo 'SELECTED';} ?>>Today</option>
				<option value="259200" <?php if ($general['top_news_period'] == 259200) {echo 'SELECTED';} ?>>Last Three Days</option>
				<option value="604800" <?php if ($general['top_news_period'] == 604800) {echo 'SELECTED';} ?>>This Week</option>
				<option value="2592000" <?php if ($general['top_news_period'] == 2592000) {echo 'SELECTED';} ?>>This Month</option>
			</select>
			</div>
		   <div class="form-group">
			<label for="site_theme">Site Theme</label>
			<select name="site_theme" id="site_theme" class="form-control">
				<?php
				$path = 'themes/';
				$results = glob($path . "*");
					foreach ($results as $result) {
						if ($result === '.' or $result === '..') continue;
						if(is_dir($result)) {
						
						echo "
						<option value='".str_replace($path,'',$result)."'";
						if ($general['site_theme'] == str_replace($path,'',$result)) {
						echo 'SELECTED';
						}
						echo ">".str_replace($path,'',$result)."</option>";		
						}
						}
						?>						
			</select>
		   </div>
		   <div class="form-group">
			<input type="checkbox" name="display_rss_link" id="display_rss_link" value="1" <?php if (isset($general['display_rss_link']) AND $general['display_rss_link'] == 1) {echo 'CHECKED';} ?> /> <span class="checkbox-label">Display RSS Link ?</span>
		  </div>
		  <div class="form-group">
			<label for="rss_news_number">Number of News in RSS file (default 10)</label>
			<select name="rss_news_number" id="rss_news_number" class="form-control">
			<?php for($r=5;$r<51;$r=$r+5) { ?>
				<option value="<?php echo $r; ?>" <?php if (isset($general['rss_news_number']) AND $general['rss_news_number'] == $r) {echo 'SELECTED';} ?>><?php echo $r; ?></option>
			<?php } ?>
			</select>
			</div>
		   <input type="hidden" name="installed" value="1" />
		  <button type="submit" name="save" class="btn btn-primary">Save</button>
		  <a href="admin" target="_BLANK" class="btn btn-success">Go to Admin Panel</a>
		</form>
	
	
	</div>
	<?php
	break;
	case 'install_db';
	$mysqli = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['name']);
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	$mysqli->set_charset("utf8");
	$admin_table = "CREATE TABLE IF NOT EXISTS `admin` (
					  `id` int(1) NOT NULL,
					  `username` varchar(40) NOT NULL,
					  `password` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	$categories_table = "CREATE TABLE IF NOT EXISTS `categories` (
					  `id` int(12) NOT NULL AUTO_INCREMENT,
					  `category` varchar(255) NOT NULL,
					  `seo_keywords` varchar(255) NOT NULL,
					  `seo_description` varchar(255) NOT NULL,
					  `menu_view` int(1) NOT NULL,
					  `index_view` int(1) NOT NULL,
					  `category_order` int(12) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

	
	$links_table = "CREATE TABLE IF NOT EXISTS `links` (
					  `id` int(12) NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) NOT NULL,
					  `link` varchar(255) NOT NULL,
					  `nofollow` int(1) NOT NULL,
					  `target` varchar(10) NOT NULL,
					  `published` int(1) NOT NULL,
					  `link_order` int(12) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

	$sources_table = "CREATE TABLE IF NOT EXISTS `sources` (
					  `id` int(12) NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) NOT NULL,
					  `rss_link` varchar(255) NOT NULL,
					  `category_id` int(12) NOT NULL,
					  `thumbnail` varchar(255) NOT NULL,
					  `news_number` int(12) NOT NULL,
					  `latest_activity` int(12) NOT NULL,
					  `auto_update` int(1) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

	$news_table = "CREATE TABLE IF NOT EXISTS `news` (
					  `id` int(12) NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) NOT NULL,
					  `permalink` varchar(255) NOT NULL,
					  `details` text NOT NULL,
					  `thumbnail` varchar(255) NOT NULL,
					  `category_id` int(12) NOT NULL,
					  `source_id` int(12) NOT NULL,
					  `datetime` int(12) NOT NULL,
					  `day` int(2) NOT NULL,
					  `month` int(2) NOT NULL,
					  `year` int(4) NOT NULL,
					  `hits` int(12) NOT NULL,
					  `published` int(1) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

	$pages_table = "CREATE TABLE IF NOT EXISTS `pages` (
					  `id` int(12) NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) NOT NULL,
					  `content` text NOT NULL,
					  `page_order` int(12) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

	$setting_table = "CREATE TABLE IF NOT EXISTS `setting` (
					  `id` int(1) NOT NULL,
					  `general` text NOT NULL,
					  `theme` text NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	
	$setting_data = "INSERT INTO `setting` (`id`, `general`, `theme`) VALUES (1, 'YToxMDp7czo3OiJzaXRldXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0L3Jzcy1zY3JpcHQvIjtzOjk6InNlb190aXRsZSI7czo0OiJOZXdzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6MjY6InBvbGl0aWNzLG5ld3Msd29ybGQsZXVyb3BlIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MTY6InNvbWUgZGVzY3JpcHRpb24iO3M6MTU6InRvcF9uZXdzX3BlcmlvZCI7czo2OiIyNTkyMDAiO3M6MTA6InNpdGVfdGhlbWUiO3M6NzoiZGVmYXVsdCI7czoxNjoiZGlzcGxheV9yc3NfbGluayI7czoxOiIxIjtzOjE1OiJyc3NfbmV3c19udW1iZXIiO3M6MjoiMTUiO3M6OToiaW5zdGFsbGVkIjtzOjE6IjEiO3M6NDoic2F2ZSI7czowOiIiO30=', 'YTo4OntzOjI1OiJob21lX2NhdGVnb3J5X25ld3NfbnVtYmVyIjtzOjE6IjYiO3M6MjA6ImNhdGVnb3J5X25ld3NfbnVtYmVyIjtzOjI6IjEyIjtzOjE4OiJzb3VyY2VfbmV3c19udW1iZXIiO3M6MjoiMTIiO3M6MTg6InNlYXJjaF9uZXdzX251bWJlciI7czoyOiIxMiI7czoxOToicmVsYXRlZF9uZXdzX251bWJlciI7czoxOiI1IjtzOjE1OiJ0b3BfbmV3c19udW1iZXIiO3M6MjoiMTAiO3M6MTQ6ImFsbG93X2xhenlsb2FkIjtzOjE6IjEiO3M6NDoic2F2ZSI7czowOiIiO30=');";
	?>
	<h4>Installing Database Table</h4>
	<div class="install-content">
	<table class="table table-stripped">
	<tr>
	<td>Admin Table</td>
	<td><?php if ($mysqli->query($admin_table)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	<tr>
	<td>Categories Table</td>
	<td><?php if ($mysqli->query($categories_table)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	<tr>
	<td>Sources Table</td>
	<td><?php if ($mysqli->query($sources_table)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	<tr>
	<td>News Table</td>
	<td><?php if ($mysqli->query($news_table)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	<tr>
	<td>Pages Table</td>
	<td><?php if ($mysqli->query($pages_table)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	<tr>
	<td>Links Table</td>
	<td><?php if ($mysqli->query($links_table)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	<tr>
	<td>Setting Table</td>
	<td><?php if ($mysqli->query($setting_table)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	<tr>
	<td>Insert Setting Data</td>
	<td><?php if ($mysqli->query($setting_data)) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></td>
	</tr>
	</table>
	</div>
	<a href="?do=install_db" class="btn btn-danger">Install Database Tables Again</a>
	<a href="?do=create_admin" class="btn btn-success">Create Admin</a>
	</div>
	<?php
	break;
	case 'check';
	?>
	<h4>Checking the requirements</h4>
	<div class="install-content">
	<table class="table">
	<tr class="active">
	<td>MySQL connection</td>
	<td align="right">
	<?php 
	$mysqli = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['name']);
	if (mysqli_connect_errno()) {
	?>
	<i class="fa fa-close text-danger"></i>
	<?php } else { ?>
	<i class="fa fa-check text-success"></i>
	<?php } ?>
	</td>
	</tr>
	<tr class="active">
	<td colspan="2">Folders Permissions</td>
	</tr>
	<tr>
	<td><i class="fa fa-folder-open"></i> upload</td>
	<td align="right">
	<?php if (is_writable('upload')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?>
	</td>
	</tr>
	<tr>
	<td><i class="fa fa-folder-open"></i> upload/news</td>
	<td align="right">
	<?php if (is_writable('upload/news')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?>
	</td>
	</tr>
	<tr>
	<td><i class="fa fa-folder-open"></i> upload/sources</td>
	<td align="right">
	<?php if (is_writable('upload/sources')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?>
	</td>
	</tr>
	<tr>
	<td><i class="fa fa-folder-open"></i> cache</td>
	<td align="right">
	<?php if (is_writable('cache')) { ?><i class="fa fa-check text-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?>
	</td>
	</tr>
	</table>
	</div>
	<div class="buttons_div">
	<span class="left"><a href="?do=check" class="btn btn-warning">Check the Requirements Again</a></span>
	<?php 
	$mysqli = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['name']);
	if (!mysqli_connect_errno()) {
	?>
	<span class="right"><a href="?do=install_db" class="btn btn-success">Install Database Tables</a></span>
	<?php } ?>
	</div>
	<?php
	break;
	default;
	?>
	<h4>Instructions</h4>
	<div class="install-content">
	
	<ul>
	<li><b>Create a new database</b></li>
	<li><b>Edit include/config.php file using your database informations</b></li>
	<li><b>CHMOD following folders with <span style="color:red;">0777</span> permissions</b>
	<ul>
	<li><i class="fa fa-folder-open"></i>upload</li>
	<li><i class="fa fa-folder-open"></i>upload/news</li>
	<li><i class="fa fa-folder-open"></i>upload/sources</li>
	<li><i class="fa fa-folder-open"></i>cache</li>
	</ul>
	</li>
	</ul>
	</div>
	<a href="?do=check" class="btn btn-primary">Let's Start</a>
	<?php
	}
	?>
	</div>
	</div>
	</div>
	</div>
	</body>
</html>