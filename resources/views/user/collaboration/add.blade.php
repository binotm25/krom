@extends('layouts.user')

@section('title')
    Collaborate
@endsection

@section('content')
    <div class="col-md-11 collab-row">

    {!! Form::open(['role'=>'form']) !!}
        <div class="row">
            <div class="col-md-8"><h1>LET'S COLLABORATE</h1>{{ $creation->title }} by {{ $creation->user->name }}</div>
            <div class="col-md-4 collab-btn-row">
                {!! Form::submit('Send', ['class' => 'btn btn-default btn-md btn-collab', 'id'=>'submit']) !!}
            </div>    
        </div>
        <hr>
        <div class="row collab-prof">
            <div class="col-md-2 collab-cust-row">
                <a href="{{ route('profile_page', ['user'=>md5(rand(9999,0000)).strrev($user->id)]) }}">
                    @if($user->profile_pic)
                    <img src="{{ URL::asset('default/images/people/'.$user->profile_pic) }}" class="center-block" height="80" width="80" alt="user-profile">
                    @else
                    <img src="{{ URL::asset('default/images/people/user.png') }}" class="center-block" height="80" width="80" alt="user-profile">
                    @endif
                </a>
            </div>    
            <div class="col-md-4 collab-cust-row">
                <h2>{{ $user->name }}</h2><p>{{ $user->city }}, {{ $user->country->country_name }}</p>
            </div>
            <div class="col-md-2 collab-cust-row">
                <a href="{{ route('profile_page', ['user'=>md5(rand(9999,0000)).strrev($creation->user->id)]) }}">
                    @if($creation->user->profile_pic)
                    <img src="{{ URL::asset('default/images/people/'.$creation->user->profile_pic) }}" class="center-block" height="80" width="80" alt="user-profile">
                    @else
                    <img src="{{ URL::asset('default/images/people/user.png') }}" class="center-block" height="80" width="80" alt="user-profile">
                    @endif
                </a>
            </div>  
            <div class="col-md-4 collab-cust-row">
                <h2>{{ $creation->user->name }}</h2><p>{{ $creation->user->city }}, {{ $creation->user->country->country_name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group collab-info-row {{ $errors->has('msg') ? 'has-error' : '' }}">
                    {!! Form::textarea('msg', null, ['size' => '8x9', 'id'=>'desc', 'class'=>'form-control']) !!}
                    {!! $errors->first('msg', '<span class="help-block">:message</span>') !!}
                </div> 
            </div>     
        </div>     
    {!! Form::close() !!}
</div> 
    
<div class="col-sm-1"></div>    
@endsection
