<?php
include('header.php'); 
if (!empty($_GET['case'])) {
$case = make_safe($_GET['case']);	
} else {
$case = '';	
}
switch ($case) {
case 'add';
if (isset($_POST['submit'])) {
$title = make_safe(xss_clean(htmlspecialchars($_POST['title'],ENT_QUOTES)));
$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
if (empty($title)) {
$message = notification('warning','Insert The Title Please.');	
} elseif (empty($content)) {
$message = notification('warning','Write Some content Please.');	
} else {
$sql = "INSERT INTO pages (title,content) VALUES ('$title','$content')";
$query = $mysqli->query($sql);
if ($query) {
$message = notification('success','Page Added Successfully.');	
} else {
$message = notification('danger','Error Happened.');	
}
}
}
?>
			<div class="page-header page-heading">
				<h1>Add Page
				<a href="pages.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="" enctype="multipart/form-data">
		  <div class="form-group">
			<label for="category">Title <span>*</span></label>
			<input type="text" class="form-control" name="title" id="title" />
		  </div>
		  <div class="form-group">
			<label for="content">content</label>
			<textarea class="form-control wysiwyg" name="content" id="content" rows="15" ></textarea>
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
<?php
break;
case 'edit';
$id = abs(intval(make_safe(xss_clean($_GET['id']))));
if (isset($_POST['submit'])) {
$title = make_safe(xss_clean(htmlspecialchars($_POST['title'],ENT_QUOTES)));
$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
if (empty($title)) {
$message = notification('warning','Insert The Title Please.');	
} elseif (empty($content)) {
$message = notification('warning','Write Some content Please.');	
} else {
$sql = "UPDATE pages SET title='$title',content='$content' WHERE id='$id'";
$query = $mysqli->query($sql);
if ($query) {
$message = notification('success','Page Edited Successfully.');	
} else {
$message = notification('danger','Error Happened.');	
}
}
}
$page = $general->page($id);
?>
			<div class="page-header page-heading">
				<h1>Edit Page
				<a href="pages.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="" enctype="multipart/form-data">
		  <div class="form-group">
			<label for="category">Title <span>*</span></label>
			<input type="text" class="form-control" name="title" id="title" value="<?php echo $page['title']; ?>" />
		  </div>
		  <div class="form-group">
			<label for="content">content</label>
			<textarea class="wysiwyg form-control" name="content" id="content" rows="15" ><?php echo htmlspecialchars_decode($page['content'],ENT_QUOTES); ?></textarea>
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
<?php
break;
case 'delete';
$id = abs(intval(make_safe(xss_clean($_GET['id']))));
if (isset($_POST['delete'])) {
$delete = $mysqli->query("DELETE FROM pages WHERE id='$id'");
if ($delete) {
$message = notification('success','Page Deleted Successfully.');
$done = true;
} else {
$message = notification('danger','Error Happened.');
}
}
$pages = $general->pages($id);
?>
			<div class="page-header page-heading">
				<h1>Delete Page
				<a href="pages.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		  <form role="form" method="POST" action="">
		  <?php if (!isset($done)) { ?>
			<div class="alert alert-warning">Are you sure to Delete the Page : <b><?php echo htmlspecialchars_decode($pages['title'],ENT_QUOTES); ?></b> ?</div>
		  <?php } ?>
		  <?php if (isset($done)) { ?>
		  <a href="pages.php" class="btn btn-default">Back To Pages</a>
		  <?php } else { ?>
		  <button type="submit" name="delete" class="btn btn-danger">Delete</button>
		  <?php } ?>
		</form>
<?php
break;
default;
?>
<div class="page-header page-heading">
	<h1><i class="fa fa-file"></i> Pages
	<a href="pages.php?case=add" class="btn btn-success  pull-right"><span class="fa fa-plus"></span></a>
	</h1>
</div>
<?php
$pages = $general->pages('page_order ASC');	
if ($pages == 0) {
echo notification('warning','You didn\'t add any Page. <a href="?case=add">Add new Page</a>.');	
} else {
?>
<div class="categories-header">
<div class="col-xs-9">Title</div>
<div class="col-xs-3"></div>
</div>
<div id="sort_pages">
<ul>
<?php
foreach ($pages AS $page) {
?>
<li id="records_<?php echo $page['id']; ?>" class="category_li" title="Drag To Re-Order">
<div class="col-xs-9"><span class="fa fa-file"></span> <?php echo $page['title']; ?></div>
<div class="col-xs-3 text-right">
	<a href="pages.php?case=edit&id=<?php echo $page['id']; ?>" class="btn btn-xs btn-default"><span class="fa fa-edit"></span></a>
	<a href="pages.php?case=delete&id=<?php echo $page['id']; ?>" class="btn btn-xs btn-danger"><span class="fa fa-close"></span></a>
</div>
</li>
<?php	
}	
?>
</ul>
</div>
<?php
}
} 
include('footer.php');
?>