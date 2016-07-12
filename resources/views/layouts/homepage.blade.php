<!DOCTYPE html>
<html lang="en" class="landscape">
<head>
<title>Kritish | Sign-Up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--Fav and touch icons-->
    <link rel="shortcut icon" href="images/favicons/favicon.png">
    <link rel="apple-touch-icon" href="images/favicons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png">
    <!-- Meta Tags -->
<meta name="author" content="Prateek Mathapati">     
<meta name="_token" content="{!! csrf_token() !!}">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ URL::asset('default/styles/bootstrap.min.css') }}">
<!-- Optional theme -->
<link rel="stylesheet" href="{{ URL::asset('default/styles/bootstrap-theme.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ URL::asset('default/styles/font-awesome.min.css') }}"> 
<!-- Custom CSS -->    
<link rel="stylesheet" href="{{ URL::asset('default/styles/style.css') }}">  
<link rel="stylesheet" href="{{ URL::asset('default/styles/ring.css') }}">      
</head>
<body class="fullscreen-body signup-bg">
 
    <!-- Top Header Row Begins -->
<div class="container margin-top">
<div class="row">
    
<div class="col-xs-3 h-logo">
<a href="{{ url('/') }}"><img src="{{ URL::asset('images/logos/kritish-logo.png') }}" class="img-responsive" width="50" alt="kritish logo"></a>    
</div>
    
<div class="col-xs-9 home-btn header-home">
    <ul>
    <li><a href="{{ url('register') }}" class="btn btn-default btn-md btn-sign">SIGN UP</a></li> 
    <li><a href="{{ url('login') }}" class="btn btn-default btn-md btn-log">LOG IN</a></li> 
    </ul>
    </div>     
</div>       
</div>   
     <!-- Top Header Row Ends -->
    
@yield('content')    
  
<!-- Scripts Link -->
<script src="{{ URL::asset('default/js/jquery-2.2.1.min.js') }}"></script>
<script src="{{ URL::asset('default/js/jquery-ui.min.js') }}"></script>    
<script src="{{ URL::asset('default/js/bootstrap.min.js') }}"></script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});
</script>
<script src="{{ URL::asset('default/js/main.js') }}"></script>
<!-- Custom Functions -->    
</body>
</html>    
