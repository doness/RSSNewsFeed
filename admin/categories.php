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
$category = make_safe(xss_clean($_POST['category']));
if (isset($_POST['index_view'])) {
$index_view = intval(make_safe(xss_clean($_POST['index_view'])));
} else {
$index_view = 0;	
}
if (isset($_POST['menu_view'])) {
$menu_view = intval(make_safe(xss_clean($_POST['menu_view'])));
} else {
$menu_view = 0;	
}
$seo_keywords = make_safe(xss_clean($_POST['seo_keywords']));
$seo_description = make_safe(xss_clean($_POST['seo_description']));
if (empty($category)) {
$message = notification('warning','Insert Category Please.');
} else {
$sql = "INSERT INTO categories (category,index_view,menu_view,seo_keywords,seo_description) VALUES ('$category','$index_view','$menu_view','$seo_keywords','$seo_description')";
$query = $mysqli->query($sql);
if ($query) {
$message = notification('success','Category Added Successfully.');
} else {
$message = notification('danger','Error Happened.');
}
}
}
?>
			<div class="page-header page-heading">
				<h1>Add New Category
				<a href="categories.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="">
		  <div class="form-group">
			<label for="category">Category <span>*</span></label>
			<input type="text" class="form-control" name="category" id="category" />
		  </div>
		<div class="form-group">
			<input type="checkbox" name="menu_view" id="menu_view" value="1" /> <span class="checkbox-label">Display Category In Menu</span>
		  </div>
		  <div class="form-group">
			<input type="checkbox" name="index_view" id="index_view" value="1" /> <span class="checkbox-label">Display Category In Home Page</span>
		  </div>
		  <div class="form-group">
			<label for="seo_keywords">SEO Keywords</label>
			<input type="text" class="form-control" name="seo_keywords" id="seo_keywords" />
		  </div>
		  <div class="form-group">
			<label for="seo_description">SEO Description</label>
			<textarea class="form-control" name="seo_description" id="seo_description" rows="3" ></textarea>
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
<?php
break;
case 'edit';
$id = abs(intval(make_safe(xss_clean($_GET['id']))));
if (isset($_POST['submit'])) {
$category = make_safe(xss_clean($_POST['category']));
if (isset($_POST['index_view'])) {
$index_view = intval(make_safe(xss_clean($_POST['index_view'])));
} else {
$index_view = 0;	
}
if (isset($_POST['menu_view'])) {
$menu_view = intval(make_safe(xss_clean($_POST['menu_view'])));
} else {
$menu_view = 0;	
}
$seo_keywords = make_safe(xss_clean($_POST['seo_keywords']));
$seo_description = make_safe(xss_clean($_POST['seo_description']));
if (empty($category)) {
$message = notification('warning','Insert Category Please.');
} else {
$sql = "UPDATE categories SET category='$category',index_view='$index_view',menu_view='$menu_view',seo_keywords='$seo_keywords',seo_description='$seo_description' WHERE id='$id'";
$query = $mysqli->query($sql);
if ($query) {
$message = notification('success','Category Edited Successfully.');
} else {
$message = notification('danger','Error Happened.');
}
}
}
$category = $general->category($id);
?>
			<div class="page-header page-heading">
				<h1>Edit Category
				<a href="categories.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="">
		  <div class="form-group">
			<label for="category">Category <span>*</span></label>
			<input type="text" class="form-control" name="category" id="category" value="<?php echo $category['category']; ?>" />
		  </div>
		<div class="form-group">
			<input type="checkbox" name="menu_view" id="menu_view" value="1" <?php if ($category['menu_view'] == 1) {echo 'CHECKED';} ?> /> <span class="checkbox-label">Display Category In Menu</span>
		  </div>
		  <div class="form-group">
			<input type="checkbox" name="index_view" id="index_view" value="1" <?php if ($category['index_view'] == 1) {echo 'CHECKED';} ?> /> <span class="checkbox-label">Display Category In Home Page</span>
		  </div>
		  <div class="form-group">
			<label for="seo_keywords">SEO Keywords</label>
			<input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="<?php echo $category['seo_keywords']; ?>" />
		  </div>
		  <div class="form-group">
			<label for="seo_description">SEO Description</label>
			<textarea class="form-control" name="seo_description" id="seo_description" rows="3" ><?php echo $category['seo_description']; ?></textarea>
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
<?php
break;
case 'delete';
$id = abs(intval(make_safe(xss_clean($_GET['id']))));
if (isset($_POST['move'])) {
$new_category = make_safe(xss_clean(intval($_POST['category_id'])));
if (empty($new_category)) {
$message = notification('warning','Please Select a Category that you want to move the Sources to.');	
} else {
$sql = "SELECT * FROM sources WHERE category_id='$id'";
$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
while ($row = $query->fetch_assoc()) {
$mysqli->query("UPDATE news SET category_id='$new_category' WHERE source_id='$row[id]'");
$mysqli->query("UPDATE sources SET category_id='$new_category' WHERE id='$row[id]'");
}	
}
$delete = $mysqli->query("DELETE FROM categories WHERE id='$id'");
if ($delete) {
$message = notification('success','Sources Moved and Category Deleted Successfully.');
$done = true;
} else {
$message = notification('danger','Error Happened.');
}
}
}
if (isset($_POST['delete'])) {
$mysqli->query("DELETE FROM news WHERE category_id='$id'");
$mysqli->query("DELETE FROM sources WHERE category_id='$id'");
$delete = $mysqli->query("DELETE FROM categories WHERE id='$id'");
if ($delete) {
$message = notification('success','Category and All related Sources and News Deleted Successfully.');
$done = true;
} else {
$message = notification('danger','Error Happened.');
}
}
$tcategory = $general->category($id);
?>
			<div class="page-header page-heading">
				<h1>Delete Category
				<a href="categories.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		  <form role="form" method="POST" action="">
		  <?php if (get_category_sources($id) > 0) { ?>
			<div class="alert alert-warning">The Category <b><?php echo $tcategory['category']; ?></b> Contains <b><?php echo get_category_sources($id); ?></b> Source(s). Do You Want To Move Them to Another Category ?</div>
		<div class="form-group">
			<label for="seo_keywords">Choose a Category to Move The Source(s) To.</label>
		  <select class="form-control" name="category_id" id="category_id">
			<?php 
			$categories = $general->categories('category_order ASC');
			foreach ($categories AS $category) {
			if ($tcategory['id'] == $category['id']) {
				
			} else {
			?>
			<option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
			<?php			
			}
			}
			?>
			</select>
		</div>
		  <?php } ?>
		  <?php if (isset($done)) { ?>
		  <a href="categories.php" class="btn btn-default">Back To Categories</a>
		  <?php } else { ?>
		  <button type="submit" name="move" class="btn btn-warning">Move Then Delete</button>
		  <button type="submit" name="delete" class="btn btn-danger">Just Delete</button>
		  <?php } ?>
		</form>
<?php
break;
default;
?>
<div class="page-header page-heading">
	<h1><i class="fa fa-reorder"></i> Categories
	<a href="categories.php?case=add" class="btn btn-success  pull-right"><span class="fa fa-plus"></span></a>
	</h1>
</div>
<?php
$categories = $general->categories('category_order ASC');	
if ($categories == 0) {
echo notification('warning','You didn\'t add any category. <a href="?case=add">Add new category</a>.');	
} else {
?>
<div class="categories-header">
<div class="col-xs-9 col-sm-5">Category</div>
<div class="col-sm-2 hidden-xs">Sources</div>
<div class="col-sm-2 hidden-xs">News</div>
<div class="col-xs-3"></div>
</div>
<div id="sort_category">
<ul>
<?php
foreach ($categories AS $category) {
?>
<li id="records_<?php echo $category['id']; ?>" class="category_li" title="Drag To Re-Order">
<div class="col-xs-9 col-sm-5"><span class="fa fa-reorder"></span> <a href="news.php?case=category&id=<?php echo $category['id']; ?>"><?php echo $category['category']; ?></a></div>
<div class="col-sm-2 hidden-xs"><?php echo get_category_sources($category['id']); ?></div>
<div class="col-sm-2 hidden-xs"><?php echo get_category_news($category['id']); ?></div>
<div class="col-xs-3 text-right">
	<a href="categories.php?case=edit&id=<?php echo $category['id']; ?>" class="btn btn-xs btn-default"><span class="fa fa-edit"></span></a>
	<a href="categories.php?case=delete&id=<?php echo $category['id']; ?>" class="btn btn-xs btn-danger"><span class="fa fa-close"></span></a>
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