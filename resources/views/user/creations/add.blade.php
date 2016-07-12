@extends('layouts.user')

@section('title')
    Add Creation
@endsection

@section('content')
    
    {!! Form::open(['route'=>'creation_add', 'role'=>'form', 'files'=>true, 'onsubmit'=>'return validateForm()']) !!}
        <div class="row add-creation">
            <div class="col-md-8"><h1>ADD CREATION</h1></div>
        </div>
        <div class="row add-creation-fields">
            <div class="col-md-8">
            
                <div class="creat-custom-width">   
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title" class="c-1">Title <span id="count"></span></label>
                        {!! Form::text('title', null, ['class' => 'form-control', 'id'=>'title']) !!}
                        {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                    </div>
                  
                    <fieldset disabled>
                        <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                            <label for="" class="c-2">Location <span class="fa fa-lock"></span></label>
                            {!! Form::text('location', Auth::user()->city.', '.Auth::user()->country_code, ['class' => 'form-control']) !!}
                        </div>
                    </fieldset>
                    
                    <div class="form-group {{ $errors->has('sel-int') ? 'has-error' : '' }}">
                        {!! Form::label('sel-int', 'Interest Area') !!}
                        {!! Form::select('sel-int', $interests->lists('title', 'id'), null, ['class' => 'form-control']) !!}
                        
                        {!! $errors->first('sel-int', '<span class="help-block">:message</span>') !!}
                    </div>

                </div> 
                    
                <div class="form-group {{ $errors->has('desc') ? 'has-error' : '' }}">
                    {!! Form::label('desc', 'Description ') !!}
                    {!! Form::textarea('desc', null, ['class' => 'form-control', 'rows' => '5', 'id'=>'description']) !!}
                    {!! $errors->first('desc', '<span class="help-block">:message</span>') !!}
                </div>

                <div class="creation-pic" id="wathi">
                    <p>Featured Images - Add up to three</p>

                    <div class="imagePreview" id="topImagePreview">
                        <div class="show-on-hover">
                            <img src="{{ url('/') }}/default/images/icons/plus-w.png" width="32" height="32">
                        </div>
                    </div>
                    {!! Form::file('uploadFile[]', ['class'=>'uploadFile img', 'multiple'=>'true', 'id'=>'uploadFile', 'accept'=>'image/*']) !!}
                    {!! $errors->first('uploadFile[]', '<span class="help-block">:message</span>') !!}
                </div>
                    
                <div class="creation-pic" id="wathi1">
                    <p>Other Images</p>    
                    <div class="imagePreview-1">
                        <div class="show-on-hover">
                            <img src="{{ url('/') }}/default/images/icons/plus-w.png" width="32" height="32">
                        </div>
                    </div>
                    {!! Form::file('uploadFile1[]', ['class'=>'uploadFile img', 'multiple'=>'true', 'id'=>'uploadFile4', 'accept'=>'image/*']) !!}
                    {!! $errors->first('uploadFile1[]', '<span class="help-block">:message</span>') !!}
                </div>
                    
            </div>    
            <div class="col-md-4"></div>    
        </div>
        <div class="add-cre-btn-row">
            <button type="submit" id="createSave" class="btn btn-default btn-md btn-add-create">SAVE</button>
        </div>    
    {!! Form::close() !!}
@endsection
