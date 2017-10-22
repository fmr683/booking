<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Banquet Hall</title>

        <!-- Vendor CSS -->
        <link href="/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
        <link href="/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
        <link href="/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">        
        <link href="/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">  
        <link href="/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <!-- CSS -->
        <link href="/css/app.min.1.css" rel="stylesheet">
        <link href="/css/app.min.2.css" rel="stylesheet">

    </head>
    <body>
        <header id="header" class="clearfix" data-current-skin="blue">
            <ul class="header-inner">
                <li id="menu-trigger" data-trigger="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>
            
                <li class="hidden-xs">
                  <!--  <a href="index.html" class="m-l-10"><img src="img/logo.jpg" alt=""></a> -->
                </li>
            </ul>

        </header>
        
        <section id="main" data-layout="layout-1">
            <aside id="sidebar" class="sidebar c-overflow">
                <div class="profile-menu">
                    <a href="">
                        <div class="profile-pic">
                            <img src="/img/profile-pics/1.png" alt="">
                        </div>

                        <div class="profile-info">
                         {{ strtoupper(Auth::user()->name) }}

                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    </a>

                    <ul class="main-menu">
         
                        <li>
							 <a href="{{ route('logout') }}"
									onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
								   <i class="zmdi zmdi-time-restore"></i>Logout
							</a>
                        </li>
                    </ul>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                </div>

                <ul class="main-menu">
                    <li><a href="/home"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="sub-menu toggled">
                        <a href=""><i class="zmdi zmdi-view-compact"></i>Booking</a>
                        <ul>
                            <li><a href="/booking/">View Bookings</a></li>
                            <li><a href="/booking/create/">Create Booking</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu toggled">
                        <a href=""><i class="zmdi zmdi-view-compact"></i> Booking Type</a>
                        <ul>
                            <li><a href="/booking-type/">View Booking Types</a></li>
                            <li><a href="/booking-type/create/">Create Booking Type</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu toggled">
                        <a href=""><i class="zmdi zmdi-view-compact"></i>Price Mapping</a>
                        <ul>
                            <li><a href="/price-mapping/">View Price Mappings</a></li>
                            <li><a href="/price-mapping/create/">Create Price Mapping</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu toggled">
                        <a href=""><i class="zmdi zmdi-view-compact"></i>Extras</a>
                        <ul>
                            <li><a href="/addon/">View Addons</a></li>
                            <li><a href="/addon/create/">Create Addon</a></li>
                        </ul>
                    </li>

                     <li class="sub-menu toggled">
                        <a href=""><i class="zmdi zmdi-view-compact"></i>User</a>
                        <ul>
                            <li><a href="/user/">View Users</a></li>
                            <li><a href="/user/create/">Create User</a></li>
                        </ul>
                    </li>

                  
                </ul>
            </aside>

            <section id="content">
                <div class="container">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                           {{ session('success') }}
                        </div>
                    @endif

                     @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                           {{ session('error') }}
                        </div>
                    @endif

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach

                  @yield('content')
                </div>
            </section>
        </section>
        
        <footer id="footer">
            Copyright &copy; <?=date("Y");?> DATA BANQUET HALL
            
           
        </footer>

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Please wait...</p>
            </div>
        </div>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>   
        <![endif]-->
        
        <!-- Javascript Libraries -->
        <script src="/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="/vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="/vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
        <script src="/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        
        <script src="/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js "></script>
        <script src="/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
        <script src="/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
        <script src="/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        <script src="/js/functions.js"></script>
          <script src="/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
        
    </body>
  </html>
