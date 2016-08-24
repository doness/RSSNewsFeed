<?php
session_start();
error_reporting(E_ERROR);
include("../include/config.php");
include("../include/connect.php");
include("include/functions.php");
include("include/nocsrf.php");
switch ($_GET['do']) {
case 'login';
if (isset($_POST)) {
try
{
NoCSRF::check('login_token', $_POST, true, 60*10, false );
$username = make_safe(xss_clean($_POST['username']));
$password = make_safe(xss_clean($_POST['password']));
if (!empty($email) OR !empty($password)) {
$sql = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
$row = $query->fetch_assoc();
if ($row['password'] == hash('sha256', md5($password))) {
$_SESSION['rss_script_admin'] = $row['id'];
echo 1;		
} else {
echo 0;
}
} else {
echo 0;
}
}
}
catch ( Exception $e )
{
echo $e->getMessage() . ' Form ignored.';
}
}
break;
default;
$login_token = NoCSRF::generate('login_token');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RSS News | Login</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	$(function() {
	$("#login").click(function() {
		var username = $("input#username").val();
		var password = $("input#password").val();
		var login_token = $("input#login_token").val();
		if (username == "") {
       $("div#message").html('<div class="alert alert-danger">Insert Username, Please.</div>');
       return false;
    }
	if (password == "") {
       $("div#message").html('<div class="alert alert-danger">Insert Password, Please.</div>');
       return false;
    }	
	$("#login").append(" <span class='fa fa-spinner fa-spin'></span>");
	var dataString = 'username='+ username + '&password=' + password+'&login_token='+login_token;
	$.ajax({
      type: "POST",
      url: 'login.php?do=login',
      data: dataString,
      success: function(result) {
	  if (result == 0) {
	    $("#login span.fa").remove();
		$("div#message").html('<div class="alert alert-danger">Error Happened</div>');
	  } else {
	  setTimeout(
		function() 
		{
		document.location.href = 'index.php';
		}, 2000);
	  }
      }
     });
    return false;
	});
});
</script>
</head>

<body class="login-body">
<div id="wrapper">
    <div class="container">
        <div class="row login-row">
            <div class="col-md-4 col-md-offset-4">
                <div id="message" style="margin-top:20px;"></div>
				<div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Admin Login</h3>
                    </div>
                    <div class="panel-body" id="login-form">
                        <form class="form" action="" method="POST" role="form">
                            <fieldset>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input class="form-control" class="form-control" placeholder="Password" name="password" id="password" type="password">
                                </div>
								<input type="hidden" name="login_token" id="login_token" value="<?php echo $login_token; ?>" />
                                <button type="submit" id="login" name="login" class="btn btn-primary btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php 
}
?>