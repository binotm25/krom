<!DOCTYPE html>
<html lang="en">
<head>
<title>Kritish | Home</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--Fav and touch icons-->
    <link rel="shortcut icon" href="images/favicons/favicon.png">
    <link rel="apple-touch-icon" href="images/favicons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png"> 
<!-- Meta Tags -->
<meta name="author" content="Prateek Mathapati">     
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ URL::asset('default/styles/bootstrap.min.css') }}">
<!-- Optional theme -->
<link rel="stylesheet" href="{{ URL::asset('default/styles/bootstrap-theme.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ URL::asset('default/styles/font-awesome.min.css') }}">
<!-- Intro CSS -->
<link rel="stylesheet" href="{{ URL::asset('default/styles/intro.css') }}">    
<!-- Custom CSS -->    
<link rel="stylesheet" href="{{ URL::asset('default/styles/style.css') }}">       
</head>
<body>

<div class="container margin-top home-menu" id="home-header">
<div class="row">
    
<div class="col-xs-3 h-logo">
<a href="{{ Auth::check() ? route('user_feeds') : ''}}"><img src="images/logos/kritish-logo.png" class="img-responsive" width="50" alt="kritish logo"></a>    
</div>
    
<div class="col-xs-9 home-btn header-home">
	@if(Auth::user())
	<ul>
		<li>
			Welcome {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}
		</li>
		<li>
			<a href="{{ url('logout') }}" class="btn btn-default btn-md btn-log">LOG OUT</a>
		</li>
	</ul>
	@else
    <ul>
		<li><a href="{{ url('register') }}" class="btn btn-default btn-md btn-sign">SIGN UP</a></li> 
		<li><a href="{{ url('login') }}" class="btn btn-default btn-md btn-log">LOG IN</a></li> 
    </ul>
    @endif
    </div>     
</div>       
</div> 
    
<div id="fullpage">
    
	<div class="section home-bg" id="section0">
            <!-- Top Header Row Begins -->
   
     <!-- Top Header Row Ends -->
    
<div class="container home-block">
<div class="row text-center">

    
<div class="col-md-3"></div>    
<div class="col-md-6">
 <img src="{{ URL::asset('default/images/logos/kritish-logo-full.png') }}" class="img-responsive center-block" width="250" alt="kitish-logo-full">   
 <p>Kritish is a prolific platform to nurture your hidden talents</p>
 <p>and inspire the world</p>
 <a href="#section1" class="btn btn-default btn-md btn-started">KNOW MORE</a>    
</div>
<div class="col-md-3"></div>   
    
</div>        
</div>
	</div>
    
  <div class="section" id="section1">
      
<div class="container">
<div class="row text-center">
    
<div class="col-md-3"></div>    
<div class="col-md-6 home-quote">
   <h3><span><img src="default/images/icons/comma-l.png" width="50" class="comma-l"></span> Happiness is not so</h3>
    <h3>much in having as <span class="home-bold">sharing.</span></h3>
    <h3>We make a living by what we get,</h3>
    <h3>but we make a life by</h3>
    <h3><span class="home-bold">what we give</span> <span><img src="default/images/icons/comma-r.png" width="50" class="comma-r"></span></h3> 
</div>
<div class="col-md-3"></div>   
</div>        
</div>
      
    </div>
    
	<div class="section" id="section2">
		<div class="container">
<div class="row text-center">
    
<div class="col-xs-2"></div>    
<div class="col-xs-4 right-border"><img src="default/images/logos/kritish-logo-w.png" class="img-responsive center-block" width="250"></div>
<div class="col-xs-4 text-left home-sec-2">
<h4>Share.</h4>
<h4>Inspire.</h4>
<h4>Collaborate.</h4>
<p>Building stronger communities through skill sharing to help you collaborate with people in the <b>REAL WORLD!</b></p>    
</div>
<div class="col-xs-2"></div>   
</div>        
</div>
	</div>
    
	<div class="section" id="section3">
        
		<div class="container">
      <div class="row text-center">
    
<div class="col-md-3"></div>    
<div class="col-md-6 explore-div">   
 <h5>Share your skills</h5>
 <h5>with the world</h5>
 <a href="{{ Auth::check() ? route('user_feeds') : url('register') }}" class="btn btn-default btn-md btn-explore">GET STARTED</a>     
</div>
<div class="col-md-3"></div>   
    
    </div>        
    </div>
     
 
    <div class="kritish-footer">   
      <p><a href="">About</a>&nbsp; &#183; &nbsp; <a href="{{ route('privacy_terms') }}" target="_blank">Terms</a>&nbsp; &#183; &nbsp;<a href="{{ route('privacy_policy') }}" target="_blank">Privacy</a>&nbsp; &#183; &nbsp;<a href="">Contacts</a> </p>  
    </div>     
        
	</div>
</div>       
    
    
<!-- Scripts Link -->
<script src="{{ URL::asset('default/js/jquery-2.2.1.min.js') }}"></script>
<script src="{{ URL::asset('default/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('default/js/intro.js') }}"></script>    
<script src="{{ URL::asset('default/js/main.js') }}"></script>   
<!-- Custom Functions -->
	<script type="text/javascript">
		$(document).ready(function() {
			$('#fullpage').fullpage({
				sectionsColor: ['transparent', '#963694', '#ee7b22', '#141a58'],
				scrollingSpeed: 1000,
                navigation:true,
                navigationPosition: 'left',
                menu: 'home-menu',
                css3: true
			});

			$('.btn-started').click(function(e){
				e.preventDefault();
				$.fn.fullpage.moveSectionDown();
			});

		});
	</script>
    
</body>
</html>    
