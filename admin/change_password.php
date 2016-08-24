<?php
include('header.php');
if (isset($_POST['submit'])) {
$current_password = make_safe(xss_clean($_POST['current_password']));
$new_password = make_safe(xss_clean($_POST['new_password']));
$confirm_password = make_safe(xss_clean($_POST['confirm_password']));
$sql = "SELECT * FROM admin WHERE id='$_SESSION[rss_script_admin]'";
$query = $mysqli->query($sql);
$row = $query->fetch_assoc();
if (empty($current_password)) {
$message = notification('warning','Please Insert The Current Password.');	
} elseif (empty($new_password)) {
$message = notification('warning','Please Insert The New Password.');	
} elseif (empty($confirm_password)) {
$message = notification('warning','Please Confirm The New Password.');		
} elseif ($new_password != $confirm_password) {
$message = notification('warning','New Password Isn\'t Match the Confirmation.');		
} elseif ($row['password'] != hash('sha256', md5($current_password))) {
$message = notification('warning','The Current Password Is Wrong.');		
} else {
$encoded_password = hash('sha256', md5($new_password));
$sql = "UPDATE admin SET password='$encoded_password' WHERE id='$_SESSION[rss_script_admin]'";
$query = $mysqli->query($sql);
if ($query) {
$message = notification('success','The Password Changed Successfully.');	
} else {
$message = notification('danger','Error Happened');	
}
}	
}
?>
			<div class="page-header page-heading">
				<h1><i class="fa fa-lock"></i> Change Password</h1>
			</div>
			<?php if (isset($message)) {echo $message;} ?>
		<form role="form" method="POST" action="">
		  <div class="form-group">
			<label for="current_password">Current Password <span>*</span></label>
			<input type="password" class="form-control" name="current_password" id="current_password" />
		  </div>
		  <div class="form-group">
			<label for="new_password">New Password <span>*</span></label>
			<input type="password" class="form-control" name="new_password" id="new_password" />
		  </div>
		  <div class="form-group">
			<label for="confirm_password">Confirm New Password <span>*</span></label>
			<input type="password" class="form-control" name="confirm_password" id="confirm_password" />
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
<?php
include('footer.php');
?>