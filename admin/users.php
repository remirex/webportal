<?php
require_once('../function.php');
require_once('class_Log.php');
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Users</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
<link href="../css/main.css" rel="stylesheet" type="text/css">
<link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="../jquery-3.1.1.min.js"></script>
<script src="main.js" type="text/javascript"></script>
	<style>
		.info a:link,
		.info a:visited{
			text-decoration: none;
			color: orange;
		}
	</style>
</head>
<body>
<header id="header">
    <?php
    include('temp_admin_header.php');
    ?>
</header><!-- end header -->
	<div class="wrapper">
		<div id="login_form">       
		<h2>Sign in with existing account</h2>
          <p id="infolog"></p>
			<form  name="formaZaLogovanje" id="formaZaLogovanje" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
				<div class="form-group">
					<label class="control-label" for="email">Email:&nbsp;&nbsp;&nbsp;</label>
				<div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-envelope"></span>
					</span>
					<input type="email" name="mail" id="email" placeholder="Email" class="form-control">
				</div>
                    <!-- provera validacije jQuery and AJAX -->
                    <span id="erremail"></span>
				</div>
				<div class="form-group">
					<label class="control-label" for="pass">Password:&nbsp;&nbsp;&nbsp;</label>
				<div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-lock"></span> 
					</span>
					<input type="password" name="pass" id="pass" placeholder="Password" class="form-control">
				</div>
                    <!-- provera validacije jQuery and AJAX-->
                    <span id="passwordSpan"></span>
				</div>
				<div class="form-group">
					<input type="button" id="login" value="Login" class="btn btn-primary">
				</div>
				<a href="forgot_password.php">Forgot your password?</a>
			</form>
		</div><!-- end login form -->
       
		<div id="registration_form">
		<h3>Not registred yet?</h3>
		<h2>Create NewsPortal Account</h2>
            <span id="info"></span>
			<form action="#" method="post">
				<div class="form-group">
					<label for="fname" class="control-label">First Name:&nbsp;&nbsp;&nbsp;</label>
					<div class="input-group">
						<span class="input-group-addon">
						<span class="glyphicon glyphicon-user"></span>
						</span>
					<input type="text" name="first_name" id="fname" placeholder="First Name" class="form-control">
					</div>
                    <span id="errfname"></span>
				</div>
				<div class="form-group">
					<label class="control-label" for="lname">Last Name:&nbsp;&nbsp;&nbsp;</label>
				<div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-user"></span>
					</span>
					<input type="text" name="last_name" id="lname" placeholder="Last Name" class="form-control">
				</div>
                    <!-- provera pomoću jQuery-a i AJAX-a -->
                    <span id="errlname"></span>
				</div>
				<div class="form-group">
					<label class="control-label" for="mail">Email:&nbsp;&nbsp;&nbsp;</label>
				<div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-envelope"></span>
					</span>
					<input type="email" name="email" id="mail" placeholder="Email" class="form-control">
				</div>
                    <!-- provera pomoću jQuery-a i AJAX-a -->
					<span id="errMail"></span>
                    <span id="exist"></span>
				</div>
				<div class="form-group">
						<label class="control-label" for="pass1">Password:&nbsp;&nbsp;&nbsp;</label>
				<div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-lock"></span>
					</span>
					<input type="password" name="password" id="pass1" placeholder="Password" class="form-control">
				</div>
                   <!-- provera pomoću jQuery-a i AJAX-a -->
                    <span id="errPass"></span>
				</div>
				<div class="form-group">
					<label class="control-label" for="pass2">Password-confirm:&nbsp;&nbsp;&nbsp;</label>
				<div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-lock"></span>
					</span>
					<input type="password" name="password2" id="pass2" placeholder="Password confirm" class="form-control">
				</div>
                  <span id="errPass2"></span>  
				</div>
				<div class="form-group">
					<input type="button" id="regist" name="btn_submit_regist" value="Register" class="btn btn-primary" disabled>
				</div>
			</form>
		</div><!-- end registration form -->
	</div>
<footer id="footer">
	<?php
	include('../temp_footer.php');
	?>
</footer><!-- end footer -->	
</body>
</html>