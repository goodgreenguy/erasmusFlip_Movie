<?php 
	error_reporting(E_ALL);
	include 'login_script.php';
	
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/app.css">
<link rel="stylesheet" type="text/css" href="plugins/bootstrap/css/bootstrap.min.css">
<link href="css/simple-sidebar.css" rel="stylesheet">
<script type="text/javascript" src="plugins/jQuery/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="plugins/jquery.rotate.1-1.js"></script>
<script type="text/javascript" src="plugins/js.cookie.js"></script>


<title>Erasmus Flip & Movie Project</title>

<nav class="navbar navbar-default navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class=""><a href="https://www.facebook.com/Erasmus-Flip-Movie-O%C5%A0-Bartul-Ka%C5%A1i%C4%87-242844366101408/"><img class="img-responsive" src="img/FB-f-Logo__blue_29.png" style="width: 70%;"></img></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Admin Login</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
							 <?php
								if(isset($_SESSION['user_is_logged_in']))
								{	echo 'Hello ' . $_SESSION['user_name'] . ', ' . $_SESSION['user_country'] . 'you are logged in.<br/><br/>';
									echo '<div class="btn-group" role="group"><a href="admin.php"><button name="admin"class="btn btn-info">Admin panel</button></a>';
									echo '<form class="form-signin form" role="form" method="post" >
														<button class="btn btn-group btn-primary" formaction="admin.php?action=logout">Log Out</button>
												</form>
											</div>';
									//echo '<a id="logout" href="index.php?action=logout">Log out</a>';
								}
								else{
								echo '<form  class="form-signin form" role="form" method="post" action="admin.php" accept-charset="UTF-8" id="login-nav" name="loginform">
										<div class="control-group">
											<label class="control-label" for="login">Login:</label>
											<div class="controls">
												<input size="50" name="user_name" id="login_input_username" value="" type="text" class="form-control" placeholder="Login" required autofocus>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="password">Password:</label>
											<div class="controls">
												<input size="50" name="user_password" id="login_input_password" value="" type="password" class="form-control" placeholder="Password">
											</div>
										</div>
										<label class="">
											<input type="checkbox" name="save" value="">Remember me</label>
										   <button name="login"  value="" type="submit" class="btn btn-large btn-primary btn-block">Sign in</button>
								 </form>';
								}
									?>
							</div>
					 </div>
				</li>
			</ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<script type="text/javascript" >
function redirect() {
	setTimeout(200);
  window.location.replace("admin.php");
  return false;
}
$(document).ready(function () {
    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z0-9_-]+$/i.test(value);
    }, "Please use only a-z0-9_-");
    $('#login-nav').validate({
        rules: {
            login: {
                minlength: 3,
                maxlength: 15,
                required: true,
                lettersonly: true
            },
            password: {
                minlength: 3,
                maxlength: 15,
                required: true,
                lettersonly: true
            },
        },
        highlight: function (element) {
            $(element).closest('.control-group').addClass('has-error');
        }
    });
});


</script>


</head>
