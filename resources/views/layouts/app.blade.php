<!DOCTYPE HTML>
<html>
    <head>
        <title>Kritish | Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Kritish Admin Panel"/>
        <meta name="author" content="Prateek Mathapati"/>  
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- Bootstrap Core CSS -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel='stylesheet' type='text/css' />
        <!-- Custom CSS -->
        <link href="{{ URL::asset('css/style.css') }}" rel='stylesheet' type='text/css' />
        <!-- Graph CSS -->
        <link href="{{ URL::asset('css/lines.css') }}" rel='stylesheet' type='text/css' />
        <link href="{{ URL::asset('css/select2.min.css') }}" rel='stylesheet' type='text/css' />
        <link href="{{ URL::asset('css/font-awesome.css') }}" rel="stylesheet"> 
        <!-- jQuery -->
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <!----webfonts--->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
        <!---//webfonts--->  
        <!-- Nav CSS -->
        <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{ URL::asset('js/metisMenu.min.js') }}"></script>
        <script src="{{ URL::asset('js/custom.js') }}"></script>
        <!-- Graph JavaScript -->
        <script src="{{ URL::asset('js/d3.v3.js') }}"></script>
        <script src="{{ URL::asset('js/rickshaw.js') }} "></script>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">Kritish</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"><img src="{{ URL::to('/') }}/images/admin/arun.png" width="40"></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu-header text-center">
                                <strong>Account</strong>
                            <li class="m_2"><a href="{{ url('/admin/logout') }}"><i class="fa fa-lock"></i> Logout</a></li>	
                        </ul>
                    </li>
                </ul>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li @if(Request::segment(1) == "") class="active" @endif>
                                <a href="{{ URL::To('/admin/') }}"><i class="fa fa-dashboard  nav_icon"></i>Dashboard</a>
                            </li>
                            <li @if(Request::segment(1) == "user") class="active" @endif>
                                <a href="{{ URL::To('/admin/user/list') }}"><i class="fa fa-users nav_icon"></i>Users</a>
                            </li>

                            <li @if(Request::segment(1) == "creation") class="active" @endif>
                                <a href="{{ URL::To('/admin/creation/list') }}"><i class="fa fa-photo nav_icon"></i>Creations</a>
                            </li>

                            <li @if(Request::segment(1) == "collaborations") class="active" @endif>
                                <a href="#"><i class="fa fa-refresh nav_icon"></i>Collaborations</a>
                            </li>

                            <li @if(Request::segment(1) == "interest") class="active" @endif>
                                <a href="{{ URL::To('/admin/interest/list') }}"><i class="fa fa-coffee nav_icon"></i>Interest Areas</a>
                            </li>

                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            <div id="page-wrapper">
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
                @yield('content')
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- Bootstrap Core JavaScript -->
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('js/select2.min.js') }}"></script>
        <script>
            $('select').select2({
                containerCss: "form-control1"
            });
        </script>
    </body>
</html>
