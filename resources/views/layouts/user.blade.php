<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--Fav and touch icons-->
    <link rel="shortcut icon" href="{{ URL::asset('default/images/favicons/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ URL::asset('default/images/favicons/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ URL::asset('default/images/favicons/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ URL::asset('default/images/favicons/apple-touch-icon-114x114.png') }}">
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
    <link rel="stylesheet" href="{{ URL::asset('default/styles/style.css') }}" media="screen">
    <link rel="stylesheet" href="{{ URL::asset('default/styles/ring.css') }}">
</head>
<body class="fullscreen-body">
 
    <!-- Top Header Row Begins -->
    <nav class="fixed-nav-bar">
        <div class="container-fluid margin-top">
            <div class="row">
        
                <div class="col-xs-3 k-logo">
                    <a href="{{ route('user_feeds') }}"><img src="{{ url('/') }}/images/logos/kritish-logo.png" class="img-responsive" width="40" alt="kritish logo"></a>    
                </div>
        
                <div class="col-xs-9 user-icons text-right">

                    <ul>
                        <li>
                            {!! Form::open(['route'=>'creation_search', 'role'=>'form']) !!}
                                {!! Form::submit('Search', ['id'=>'search_things', 'style'=>'display:none']) !!}
                                <div class="form-group has-feedback">
                                    {!! Form::text('search', null, ['class'=>'form-control search', 'placeholder'=>'Search']) !!}
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                            {!! Form::close() !!}
                        </li>    
                        <li>
                            <a href="{{ route('creation_add') }}">
                                <img src="{{ URL::asset('default/images/icons/plus.png') }}" width="33" alt="add" title="Add A New Creation">
                            </a>
                        </li>    
                        <li class="dropdown user-icons-user">
                            <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                                @if(Auth::user()->profile_pic)
                                    <img src="{{ URL::asset('default/images/people/'.Auth::user()->profile_pic) }}" width="36" height="35" alt="user" title="{{ Auth::user()->name }}">
                                @else
                                    <img src="{{ URL::asset('default/images/icons/user.png') }}" width="36" height="35" alt="user" title="{{ Auth::user()->name }}">
                                @endif
                            </a> 
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('edit_profile') }}"><i class="fa fa-pencil"></i> Edit Profile</a></li>
                                <li>
                                    <a href="{{ route('privacy_terms') }}" target="_blank"><i class="fa fa-file-text"></i> Terms</a>
                                </li>
                                <li>
                                    <a href="{{ route('privacy_policy') }}" target="_blank"><i class="fa fa-user-secret"></i> Privacy</a>
                                </li>
                                <li><a href="{{ url('/logout/') }}"><i class="fa fa-lock"></i> Logout</a></li>
                            </ul>   
                        </li>
                    </ul>  
        
                </div>     

            </div>    
        </div>
    </nav>
        
  <!-- Top Header Row Ends -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                @include('layouts.sidebar')
            </div>
            <div class="gap-timeline"></div>
            <div class="col-md-8">
                @yield('content')
            </div>

        </div>   
    </div>  
    
<!-- Custom Functions -->    
    <script src="{{ URL::asset('default/js/jquery-2.2.1.min.js') }}"></script>
    <script src="{{ URL::asset('default/js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('default/js/bootstrap.min.js') }}"></script>
    <script>
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

        $(document).ready(function() {
            $('.gap-timeline').addClass('timeline-gap');
            $('.fixed-nav-bar').addClass('sticky');
            $('.sidebar-nav').css('margin-top', '84px');
        });

    </script>
    <script src="{{ URL::asset('default/js/main.js') }}"></script>
<!-- Scripts Link -->
    @yield('customJsFiles')      

@include('layouts.pop')
@include('layouts.partials._praisePop')
<div class="modal" id="collaborate_form" role="dialog" tabindex="-1" role="dialog" aria-labelledby="modalLargeLabel" aria-hidden="true"></div>
</body>
</html>    
