

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>BluGraph BluLevel</title>
	<link href="../pub/images/favicon.ico" rel="icon" type="image/x-icon" />
	<link rel="apple-touch-icon" href="images/bg.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/bg.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/bg.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/bg.png">
	<link rel="apple-touch-startup-image" href="images/bg.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../pub/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	 <!-- DATA TABLES -->
    <link href="../pub/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../pub/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../pub/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body onload="load()" class="skin-purple">
    <!-- Site wrapper -->
    <div class="wrapper">
      
      <header class="main-header">
            <!-- Logo -->
            <a href="map.php" class="logo"><b style="color:#1c449c;">BG -</b><img src="../pub/dist/img/pub_logo.png" style="margin-left:5px;"  alt="PUB" /></a>
			<!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../pub/dist/img/user2-160x160.png" class="user-image" alt="User Image" />
                                <span class="hidden-xs"><?php echo "$username"; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="../pub/dist/img/user2-160x160.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo "$username"; ?> 
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="../index.html" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>