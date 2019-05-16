<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>BluGraph BluPower</title>
	<link href="images/favicon.ico" rel="icon" type="image/x-icon" />
	<link rel="apple-touch-icon" href="images/bg.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/bg.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/bg.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/bg.png">
	<link rel="apple-touch-startup-image" href="images/bg.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
   
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

      <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-red">

      <header class="main-header">
            <!-- Logo -->
            <a href="#" class="logo"><b>BluGraph</b>- BluPower</a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
              
               
            </nav>
        </header>
		<?php
		
			if (isset($_POST["submit1"]))
			{
				header("Location: /rhythms/login.html");
				exit(0); 
			}
		
		?>

    <div class="login-box" style="border:solid 1px;">
      
      <div class="login-box-body">
        <p class="login-box-msg">Invalid User Name / Password</p>
        <form action="user_action.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="User Name"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
                                     
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color:#dd4b39;">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
     
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>