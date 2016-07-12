@extends('layouts.user')

@section('title')
    {{ $userData->name }}'s Profile
@endsection

@section('content')
    {!! Form::model($userData, ['method'=>'PATCH', 'role'=>'form', 'class'=>'edit-profile-row']) !!}
        <div class="row submit-row">
            <div class="col-md-6"><h1>Edit Profile</h1></div>     
        </div>    
            <!-- cover pic -->
        <div class="row">
            <div class="col-md-12">
                
                <div class="edit-cover">
                    <div class="trans-layer-1"></div>
                    @if($userData->cover_pic)
                        <img src="{{ URL::asset('uploads/cover/'.$userData->cover_pic) }}" class="cover-pic-2" alt="kritish-cover-photo">
                    @else
                        <img src="{{ URL::asset('default/images/cover/galaxy.jpg') }}" class="cover-pic-2" alt="kritish-cover-photo">
                    @endif
                    <div class="camera-edit-1"><img src="{{ URL::asset('default/images/icons/camera.png') }}" width="64" height="64">
                    </div>
                    {!! Form::file('userImage', ['class'=>'uploadFile img', 'id'=>'media']) !!}
                </div>

            </div>    
        </div>

        <!-- Profile pic -->    
        <div class="row profile-pic-row">
            <div class="col-md-3">
                <div id='status'></div>
                <div class="edit-profile-pic">
                    <div class="trans-layer-2"></div>
                    @if($userData->profile_pic) 
                        <img src="{{ URL::asset('default/images/people/'.$userData->profile_pic) }}" class="profile-pic-2" alt="kritish-profile-pic">
                    @else
                        <img src="{{ URL::asset('default/images/icons/user.png') }}" class="profile-pic-2" alt="kritish-profile-pic">
                    @endif
                    <div class="camera-edit-2"><img src="{{ URL::asset('default/images/icons/camera.png') }}" width="50" height="50">
                    </div>{!! Form::file('userImage', ['class'=>'uploadFile img', 'id'=>'profilePic']) !!}
                </div>
            </div>    

            <div class="col-md-6"></div>
                <div class="col-md-3 pwd-link"><p><a href="{{ route('change_password') }}">Change Password</a></p>  </div>

        </div>

        <!-- Form Row 1-->
        <div class="row">    
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="editname" class="p-l-1">Name <span class="fa fa-pencil"></span></label>
                    {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'editname']) !!}
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>    
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="editemail" class="p-l-2">Email <span class="fa fa-pencil"></span></label>
                    {!! Form::email('email', null, ['class'=>'form-control', 'id'=>'editemail']) !!}
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>    
            </div>

            <div class="col-md-4 pwd-link">
                <!--<p><a href="">Change Password</a></p> -->  
            </div>       
        </div>

        <!-- Form Row 2-->
        <div class="row">    
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                    <label for="editcity" class="p-l-3">City <span class="fa fa-pencil"></span></label>
                    {!! Form::text('city', null, ['class'=>'form-control', 'id'=>'editcity']) !!}
                    {!! $errors->first('city', '<span class="help-block">:message</span>') !!}
                </div>    
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('country_code') ? 'has-error' : '' }}">
                    <label for="editcountry" class="p-l-4">Country <span class="fa fa-pencil"></span></label>
                    {!! Form::select('country_code', $userData->country->lists('country_name', 'country_code'), null, ['class'=>'form-control', 'id'=>'editcountry']) !!}
                    {!! $errors->first('country_code', '<span class="help-block">:message</span>') !!}
                </div>    
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('zip_code') ? 'has-error' : '' }}">
                    <label for="editzip" class="p-l-5">Zip Code <span class="fa fa-pencil"></span></label>
                    {!! Form::text('zip_code', null, ['class'=>'form-control', 'id'=>'editzip']) !!}
                    {!! $errors->first('zip_code', '<span class="help-block">:message</span>') !!}
                </div>    
            </div>       
        </div>

        <hr>

        <!-- Form Row 3-->
        <div class="row">    
            <div class="col-md-12">
            
                <div class="form-group {{ $errors->has('my_story') ? 'has-error' : '' }}">
                    <label for="editstory" class="p-l-6">My Story <span class="fa fa-pencil"></span></label>
                    {!! Form::textarea('my_story', null, ['class'=>'form-control', 'id'=>'editstory', 'rows' => '5']) !!}
                    {!! $errors->first('my_story', '<span class="help-block">:message</span>') !!}
                </div> 

                <div class="form-group {{ $errors->has('my_work_my_life') ? 'has-error' : '' }}">
                    <label for="editlife" class="p-l-7">My Work My Life <span class="fa fa-pencil"></span></label>
                    {!! Form::textarea('my_work_my_life', null, ['class'=>'form-control', 'id'=>'editlife', 'rows' => '5']) !!}
                    {!! $errors->first('my_work_my_life', '<span class="help-block">:message</span>') !!}
                </div> 

            </div>
        </div>
        <div class="edit-prof-btn-row">
            <button type="submit" class="btn btn-default btn-md btn-e-prof">SAVE</button>
        </div>   
    {!! Form::close() !!}
    
    @include('layouts.partials._popUpLoader')

@endsection
