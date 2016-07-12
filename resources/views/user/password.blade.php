@extends('layouts.user')

@section('title')
    Change Password
@endsection

@section('content')

{!! Form::open(['role'=>'form', 'files'=>true]) !!}
    <div class="row change-pwd">
        <div class="col-md-8"><h1>CHANGE PASSWORD</h1></div>
    </div>
       
        
    <div class="row change-pwd-fields">
        <div class="col-md-8">
            <div class="form-group {{ $errors->has('c_pass') ? 'has-error' : '' }}">
                <label for="email" class="l-1">Current Password <span class="fa fa-pencil"></span></label>
                {!! Form::password('c_pass', ['class'=>'form-control', 'id'=>'p_pwd']) !!}
                {!! $errors->first('c_pass', '<span class="help-block">:message</span>') !!}
            </div>
        
            <div class="form-group {{ $errors->has('pwd') ? 'has-error' : '' }}">
                <label for="pwd" class="l-2">New Password <span class="fa fa-pencil"></span></label>
                {!! Form::password('pwd', ['class'=>'form-control', 'id'=>'n_pwd']) !!}
                {!! $errors->first('pwd', '<span class="help-block">:message</span>') !!}
            </div>
        
            <div class="form-group {{ $errors->has('pwd_c') ? 'has-error' : '' }}">
                <label for="pwd" class="l-3">Confirm Password <span class="fa fa-pencil"></span></label>
                {!! Form::password('pwd_c', ['class'=>'form-control', 'id'=>'c_pwd']) !!}
                {!! $errors->first('pwd_c', '<span class="help-block">:message</span>') !!}
            </div>
            <div id="pwd_check" class="text-center"></div>
        </div>
        
        <div class="col-md-4"></div>
    </div>
    <div class="pwd-btn-row">
        <button type="submit" class="btn btn-default btn-md btn-c-pwd">SAVE</button>
    </div>
{!! Form::close() !!}

<div class="clearfix"></div>

@endsection