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
$title = make_safe(xss_clean($_POST['title']));
$category_id = intval(make_safe(xss_clean($_POST['category_id'])));
$rss_link = make_safe(xss_clean($_POST['rss_link']));
if (isset($_POST['auto_update'])) {
$auto_update = intval(make_safe(xss_clean($_POST['auto_update'])));
} else {
$auto_update = 0;
}
$news_number = intval(make_safe(xss_clean($_POST['news_number'])));
if (empty($title)) {
$message = notification('warning','Insert Resource Name Please.');
} elseif (empty($rss_link)) {
$message = notification('warning','Insert RSS Url Please.');
} elseif (empty($category_id)) {
$message = notification('warning','Choose a Category Please.');
} else {
if (!empty($_FILES['thumbnail']['name'])) {
$up = new fileDir('../upload/sources/');
$thumbnail = $up->upload($_FILES['thumbnail']);
} else {
$thumbnail = '';
}
$sql = "INSERT INTO sources (title,rss_link,category_id,thumbnail,news_number,auto_update) VALUES ('$title','$rss_link','$category_id','$thumbnail','$news_number','$auto_update')";
$query = $mysqli->query($sql);
if ($query) {
$message = notification('success','Source Added Successfully.');
} else {
$message = notification('danger','Error Happened.');
}
}
}
?>
			<div class="page-header page-heading">
				<h1>Add New Source
				<a href="sources.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="" enctype="multipart/form-data">
		  <div class="form-group">
			<label for="title">Source Name <span>*</span></label>
			<input type="text" class="form-control" name="title" id="title" />
		  </div>
		  <div class="form-group">
			<label for="rss_link">RSS Url <span>*</span></label>
			<input type="text" class="form-control" name="rss_link" id="rss_link" />
		  </div>
		  <div class="form-group">
			<label for="category_id">Category <span>*</span></label>
			<select class="form-control" name="category_id" id="category_id">
			<?php 
			$categories = $general->categories('category_order ASC');
			foreach ($categories AS $category) {
			?>
			<option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
			<?php			
			}
			?>
			</select>
		  </div>
		  <div class="form-group">
			<label for="news_number">News Number Per Grab <span>*</span></label>
			<select class="form-control" name="news_number" id="news_number">
			<?php 
			for($i=1;$i<31;$i++) {
			?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php			
			}
			?>
			</select>
		  </div>
		 <div class="form-group">
			<label for="category_id">Thumbnail</label>
			<div class="fileinput fileinput-new input-group" data-provides="fileinput">
			  <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
			  <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="thumbnail"></span>
			  <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
			</div>
		  </div>
		  <div class="form-group">
			<input type="checkbox" name="auto_update" id="auto_update" value="1" /> <span class="checkbox-label">Auto Update Source ?</span>
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
<?php
break;
case 'edit';
$id = abs(intval(make_safe(xss_clean($_GET['id']))));
if (isset($_POST['submit'])) {
$title = make_safe(xss_clean($_POST['title']));
$category_id = intval(make_safe(xss_clean($_POST['category_id'])));
$rss_link = make_safe(xss_clean($_POST['rss_link']));
if (isset($_POST['auto_update'])) {
$auto_update = intval(make_safe(xss_clean($_POST['auto_update'])));
} else {
$auto_update = 0;
}
$news_number = intval(make_safe(xss_clean($_POST['news_number'])));
if (empty($title)) {
$message = notification('warning','Insert Resource Name Please.');
} elseif (empty($rss_link)) {
$message = notification('warning','Insert RSS Url Please.');
} elseif (empty($category_id)) {
$message = notification('warning','Choose a Category Please.');
} else {
if (!empty($_FILES['thumbnail']['name'])) {
$up = new fileDir('../upload/sources/');
$thumbnail = $up->upload($_FILES['thumbnail']);
$up->delete("$_POST[old_thumbnail]");
} else {
$thumbnail = $_POST['old_thumbnail'];
}
$sql = "UPDATE sources SET title='$title',rss_link='$rss_link',category_id='$category_id',thumbnail='$thumbnail',news_number='$news_number',auto_update='$auto_update' WHERE id='$id'";
$query = $mysqli->query($sql);
if ($query) {
$mysqli->query("UPDATE news SET category_id='$category_id' WHERE source_id='$id'");
$message = notification('success','Source Added Successfully.');
} else {
$message = notification('danger','Error Happened.');
}
}
}
$source = $general->source($id);
?>
			<div class="page-header page-heading">
				<h1>Add New Source
				<a href="sources.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="" enctype="multipart/form-data">
		  <div class="form-group">
			<label for="title">Source Name <span>*</span></label>
			<input type="text" class="form-control" name="title" id="title" value="<?php echo $source['title']; ?>" />
		  </div>
		  <div class="form-group">
			<label for="rss_link">RSS Url <span>*</span></label>
			<input type="text" class="form-control" name="rss_link" id="rss_link" value="<?php echo $source['rss_link']; ?>" />
		  </div>
		  <div class="form-group">
			<label for="category_id">Category <span>*</span></label>
			<select class="form-control" name="category_id" id="category_id">
			<?php 
			$categories = $general->categories('category_order ASC');
			foreach ($categories AS $category) {
			?>
			<option value="<?php echo $category['id']; ?>" <?php if ($source['category_id'] == $category['id']) {echo 'SELECTED';} ?>><?php echo $category['category']; ?></option>
			<?php			
			}
			?>
			</select>
		  </div>
		  <div class="form-group">
			<label for="news_number">News Number Per Grab <span>*</span></label>
			<select class="form-control" name="news_number" id="news_number">
			<?php 
			for($i=1;$i<31;$i++) {
			?>
			<option value="<?php echo $i; ?>" <?php if ($source['news_number'] == $i) {echo 'SELECTED';} ?>><?php echo $i; ?></option>
			<?php			
			}
			?>
			</select>
		  </div>
		 <div class="form-group">
			<label for="category_id">Thumbnail</label>
			<div class="fileinput fileinput-new input-group" data-provides="fileinput">
			  <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
			  <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="thumbnail"></span>
			  <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
			</div>
			</div>
		  <div class="form-group">
			<input type="checkbox" name="auto_update" id="auto_update" value="1" <?php if ($source['auto_update'] == 1) {echo 'CHECKED';} ?> /> <span class="checkbox-label">Auto Update Source ?</span>
		  </div>
		  <input type="hidden" name="old_thumbnail" value="<?php echo $source['thumbnail']; ?>" />
		  <button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
<?php
break;
case 'delete';
$id = abs(intval(make_safe(xss_clean($_GET['id']))));
if (isset($_POST['delete'])) {
$sql = "SELECT * FROM news WHERE source_id='$id'";
$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
while ($row = $query->fetch_assoc()) {	
if (!empty($row['thumbnail']) AND file_exists('../upload/news/'.$row['thumbnail'])) {
@unlink('../upload/news/'.$row['thumbnail']);	
}
$mysqli->query("DELETE FROM news WHERE id='$row[id]'");
}
}
$delete = $mysqli->query("DELETE FROM sources WHERE id='$id'");
if ($delete) {
$message = notification('success','Source and All related News Deleted Successfully.');
$done = true;
} else {
$message = notification('danger','Error Happened.');
}
}
$source = $general->source($id);
?>
			<div class="page-header page-heading">
				<h1>Delete Source
				<a href="sources.php" class="btn btn-default  pull-right"><span class="fa fa-arrow-right"></span></a>
				</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		  <form role="form" method="POST" action="">
		  <?php if (!isset($done) AND get_source_news($id) > 0) { ?>
			<div class="alert alert-warning">The Source <b><?php echo $source['title']; ?></b> Contains <b><?php echo get_source_news($id); ?></b> Article(s). Do You Want To Delete this Source and all Related Articles ?</div>
		  <?php } else { ?>
		  <div class="alert alert-warning">The Source <b><?php echo $source['title']; ?></b> is Empty. Process to Delete ?</div>
		  <?php } ?>
		  <?php if (isset($done)) { ?>
		  <a href="sources.php" class="btn btn-default">Back To Sources</a>
		  <?php } else { ?>
		  <a href="sources.php" class="btn btn-default">Cancel</a>
		  <button type="submit" name="delete" class="btn btn-danger">Delete</button>
		  <?php } ?>
		</form>
<?php
break;
default;
?>
<div class="page-header page-heading">
	<h1><i class="fa fa-rss"></i> Sources
	<a href="sources.php?case=add" class="btn btn-success  pull-right"><span class="fa fa-plus"></span></a>
	</h1>
</div>
<?php
$page = 1;
$size = 20;
if (isset($_GET['page'])){ $page = (int) $_GET['page']; }
$sqls = "SELECT * FROM sources ORDER BY id DESC";
$query = $mysqli->query($sqls);
$total_records = $query->num_rows;
if ($total_records == 0) {
echo notification('warning','You didn\'t add any Source. <a href="?case=add">Add New Source</a>');
} else {
$pagination = new Pagination();
$pagination->setLink("?page=%s");
$pagination->setPage($page);
$pagination->setSize($size);
$pagination->setTotalRecords($total_records);
$get = "SELECT * FROM sources ORDER BY id DESC ".$pagination->getLimitSql();
$q = $mysqli->query($get);
?>
<table width="100%" cellpadding="5" cellspacing="0" class="table table-striped">
    <thead>
        <tr>
			<th>Source</th>
			<th class="hidden-xs">Category</th>
			<th class="hidden-xs">News</th>
			<th class="hidden-xs">Latest Update</th>
            <th></th>
        </tr>
    </thead>
	<tbody>
<?php 
while ($row = $q->fetch_assoc()) {
?>
		<tr>
			<td><a href="news.php?case=source&id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
			<td class="hidden-xs"><?php echo get_category($row['category_id']); ?></td>
			<td class="hidden-xs"><?php echo get_source_news($row['id']); ?></td>
			<td class="hidden-xs"><?php if ($row['latest_activity'] == 0) {echo 'Not Updated Yet';} else {echo date('Y-n-j h:i a',$row['latest_activity']);} ?></td>
			<td align="right">
				<a class="news_grab btn btn-primary btn-xs" href="javascript:void();" id="<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Grab"><span class="fa fa-refresh"></span></a>
				<a class="btn btn-default btn-xs" href="sources.php?case=edit&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></a>
				<a class="btn btn-danger btn-xs" href="sources.php?case=delete&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-close"></span></a>
			</td>
		</tr>
<?php
}
?>
	</tbody>
</table>
<?php
echo $pagination->create_links();
}
} 
include('footer.php');
?>