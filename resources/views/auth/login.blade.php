@extends('layouts.homepage')

@section('content')

<div class="container login-block">
<div class="row text-center">

    
<div class="col-md-4"></div>    
<div class="col-md-4">
    @if(Session::has('verify_email'))
        <span class="verify_email">
           {{ Session::get('verify_email') }}
        </span>
    @endif
    <img src="default/images/logos/kritish-logo-full.png" class="img-responsive center-block" width="250" alt="kitish-logo-full">   
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control" id="name" placeholder="Email" name="email" value="{{ old('email') }}"  autocomplete="false">
            @if ($errors->has('email'))
          		  <span class="help-block">
          			   {{ $errors->first('email') }}
          		  </span>
          	@endif
        </div>
      
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" id="email" placeholder="Password" name="password">
            @if ($errors->has('password'))
      		      <span class="help-block">
            			 {{ $errors->first('password') }}
            		</span>
  	        @endif
        </div>

        <div class="checkbox">
            <label><input type="checkbox" value="" name="remember">Remember me</label>
        </div>
      
        <button type="submit" class="btn btn-default btn-log-2">LOGIN</button>
      
    </form>
    <a href="{{ url('/password/reset') }}"><span class="fa fa-question-circle"></span> Forgot Password</a>
</div>
<div class="col-md-4"></div>   
@endsection