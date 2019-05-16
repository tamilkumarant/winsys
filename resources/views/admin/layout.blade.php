<?php 
	use App\Helper;	
    use App\Models\Station;

	$segment = Request::segment(1);
	
	$map = Helper::checkAuthFunction(1);
	$project = Helper::checkAuthFunction(2);
	$location = Helper::checkAuthFunction(3);
	$user = Helper::checkAuthFunction(4);
	$menu = Helper::checkAuthFunction(5);
	$menuaccess = Helper::checkAuthFunction(6);
	$dashboardData = Helper::checkAuthFunction(7);
	$summaryData = Helper::checkAuthFunction(8);
	$individualChart = Helper::checkAuthFunction(9);
	$stationGrouping = Helper::checkAuthFunction(10);
	$summary50 = Helper::checkAuthFunction(11);
	$summary75 = Helper::checkAuthFunction(12);
	$wlMaxMin = Helper::checkAuthFunction(13);
	$selfAuditing = Helper::checkAuthFunction(14);
	$smsList = Helper::checkAuthFunction(15);
	$stationGroup = Helper::checkAuthFunction(17);
	$calibration = Helper::checkAuthFunction(18);
	
	$username = isset(Auth::user()->username)?(Auth::user()->username):null;

	
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>BluGraph BluLevel</title>
    <link href="{{asset('/favicon.ico')}}" rel="icon" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/bg.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/bg.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/bg.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/bg.png">
    <link rel="apple-touch-startup-image" href="images/bg.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{asset('/public/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="{{asset('/public/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/public/admin/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/public/admin/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('/public/admin/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="{{asset('/public/admin/dist/css/skins/_all-skins.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/public/admin/dist/css/style.css')}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	@yield('css')
</head>

<body class="skin-purple @if($segment!='map') sidebar-collapse  @endif">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <!-- <div class="leftsearchfilter container "> -->
                    <div class="col-sm-4 col-md-3 col-lg-2 no-padding">
                         <a href="{{url('dashboard')}}" class="logo"><b style="color:#1c449c;">BG -</b><img src="{{asset('/public/admin/dist/img/pub_logo.png')}}" style="margin-left:5px;"  alt="PUB" /></a>
						<!-- <div class="navbar-header">
							 <b style="color:#1c449c;">BG -</b><img src="{{asset('/public/admin/dist/img/pub_logo.png')}}"  alt="PUB" /> 
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="true">
								<i class="fa fa-bars"></i>
							</button>
						</div> --> 
                    </div> 

                    <!-- Collect the nav links, forms, and other content for toggling -->
					<div class="col-sm-8 col-md-9 col-lg-10 no-padding">
                    <div class="navbar-collapse pull-left collapse in" id="navbar-collapse" aria-expanded="true" style="">
                      <ul class="nav navbar-nav ">
                        <li class="@if($segment=='map') active @endif">
                            <a href="{{url('map/0')}}">HOME</a>
                        </li>
                        <li>
                            <a href="{{url('status')}}">STATUS</a>
                        </li>
                        <li>
                            <a href="{{url('map/0')}}">DATA</a>
                        </li>
                        <li>
                            <a href="{{url('map/0')}}">EXPORT</a>
                        </li>
                        <li>
                            <a href="{{url('map/0')}}">COMPARE</a>
                        </li>
                        <li class="@if($segment=='station') active @endif">
                            <a href="{{url('station')}}">STATIONS</a>
                        </li>
                        <li>
                            <a href="{{url('map/0')}}">FILES</a>
                        </li>
                        <li>
                            <a href="{{url('map/0')}}">OVERVIEW</a>
                        </li>
                         <li class="dropdown @if($segment=='menu-access' || $segment=='menu' || $segment=='user' || $segment=='project' ) active @endif">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">ADMINISTRATION <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li class="@if($segment=='project') active @endif"><a href="{{url('project')}}">Project</a></li>
                            <li class="@if($segment=='menu') active @endif"><a href="{{url('menu')}}">Menu</a></li>
                            <li class="@if($segment=='menu-access') active @endif"><a href="{{url('menu-access/0')}}">Menu Access</a></li>
                            <li class="@if($segment=='user') active @endif"><a href="{{url('user')}}">Users</a></li>
                          </ul>
                        </li> 
                      </ul>
                     <!--  <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                          <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                        </div>
                      </form> -->
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->

                    
                    <div class="navbar-custom-menu">
                      <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        
                        <!-- /.messages-menu -->

                        <!-- Notifications Menu -->
                        
                        <!-- Tasks Menu -->
                        
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                          <!-- Menu Toggle Button -->
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('/public/admin/dist/img/user2-160x160.png')}}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{$username}}</span>
                          </a>
                          <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{asset('/public/admin/dist/img/user2-160x160.png')}}" class="img-circle" alt="User Image" />
                                <p class="hidden-xs">{{$username}}</p>
                             
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                              <div class="pull-left">
                                <a href="{{url('profile')}}" class="btn btn-default btn-flat">Profile</a>
                              </div>
                              <div class="pull-right">
                                <a href="{{url('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                              </div>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                    
                    </div>
                <!-- </div> -->
              <!-- /.container-fluid -->



            </nav>


          </header>
          <div class="clear"></div>

<?php /*
        <header class="main-header">
            <!-- Logo -->
            <a href="{{url('dashboard')}}" class="logo"><img src="{{asset('/public/admin/dist/img/pub_logo.png')}}" style="" width="215" height="50"  alt="PUB" /></a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a> -->

                <div class="container">
                    <!-- <div class="navbar-header">
                      <a href="../../index2.html" class="navbar-brand"><b>Admin</b>LTE</a>
                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="true">
                        <i class="fa fa-bars"></i>
                      </button>
                    </div> -->

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="navbar-collapse pull-left collapse in" id="navbar-collapse" aria-expanded="true" style="">
                      <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">HOME</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">STATUS</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">DATA</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">EXPORT</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">COMPARE</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">STATIONS</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">FILES</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="{{url('map/0')}}" class="">
                                <span class="hidden-xs">OVERVIEW</span>
                            </a>
                        </li>
                        <!-- <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdown <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                          </ul>
                        </li> -->
                      </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <!-- /.navbar-custom-menu -->
                  </div>

                
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('/public/admin/dist/img/user2-160x160.png')}}" class="user-image" alt="User Image" />
                                <span class="hidden-xs">{{$username}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{asset('/public/admin/dist/img/user2-160x160.png')}}" class="img-circle" alt="User Image" />
                                    <p>
                                       {{$username}}
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{url('profile')}}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{url('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        */ ?>

        <!-- =============================================== -->
        

        
		
        <div class="content-wrapper">
    			@yield('content')
		</div>
        <!-- =============================================== -->

        <footer class="main-footer">
            <strong>Copyright &copy; {{date('Y')}} <a href="http://blugraph.com">blugraph.com</a>.</strong> All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery 2.1.3 -->
    <script src="{{asset('/public/admin/plugins/jQuery/jQuery-2.1.3.min.js')}}"></script>
    <script src="{{asset('/public/admin/plugins/jQuery/jQuery-2.1.3.min.js')}}"></script>
		
    <script src="{{URL::to('public/admin/dist/js/jquery.validate.js')}}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{asset('/public/admin/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="{{asset('/public/admin/plugins/slimScroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
	
    <script src="{{asset('public/admin/plugins/datatables/jquery.dataTables.js')}}"></script>
	
    <script src="{{asset('public/admin/plugins/datatables/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('/public/admin/plugins/fastclick/fastclick.min.js')}}"></script>
    <script src="{{asset('/public/admin/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('/public/admin/plugins/select2/select2.full.min.js')}}"></script>
    <!-- AdminLTE App -->	
    <script src="{{asset('/public/admin/dist/js/app.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/public/admin/dist/js/script.js')}}" type="text/javascript"></script>
	<script>
		/*$(function(){
			$('.navbar-custom-menu').click(function(){
				console.log(this);
			});
		});*/
	</script>
	@yield('js')
</body>

</html>