@extends('layouts.homepage')

@section('content')

<div class="container login-block">
<div class="row text-center">
<h3 style="color: white;">Reset Your Password</h3>
<div class="col-md-3"></div>    
<div class="col-md-6">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <img src="{{URL::asset('default/images/logos/kritish-logo-full.png')}}" class="img-responsive center-block" width="250" alt="kitish-logo-full">   
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
        {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="col-md-5 control-label" style="color: white;">E-Mail Address</label>

            <div class="col-md-7">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-2 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-md btn-sign">
                    <i class="fa fa-btn fa-envelope"></i>Send Password Reset Link
                </button>
            </div>
        </div>
      
    </form>
</div>
<div class="col-md-4"></div>   
@endsection