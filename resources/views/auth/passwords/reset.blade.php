@extends('layouts.homepage')

@section('content')

<div class="container login-block">
<div class="row text-center">
<h3 style="color: white;">Reset Password</h3>
<div class="col-md-3"></div>    
<div class="col-md-6">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <img src="{{URL::asset('default/images/logos/kritish-logo-full.png')}}" class="img-responsive center-block" width="250" alt="kitish-logo-full">   
    <form class="form-horizontal reset-password" role="form" method="POST" action="{{ url('/password/reset') }}">
    {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Confirm Password</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-2 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-md btn-sign">
                    <i class="fa fa-btn fa-refresh"></i>Reset Password
                </button>
            </div>
        </div>      
    </form>
</div>
<div class="col-md-4"></div>   
@endsection
