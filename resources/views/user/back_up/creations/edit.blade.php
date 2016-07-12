@extends('layouts.user')

@section('title')
    Edit Creation
@endsection

@section('content')

    {!! Form::model($creation, ['url'=>url('/').'/creation/'.Request::segment(2), 'method'=>'PATCH', 'role'=>'form', 'files'=>true]) !!}
        <div class="row add-creation">
            <div class="col-md-8"><h1>EDIT CREATION</h1></div>    
            <div class="col-md-4">
                <span class="btn btn-default btn-md btn-add-create" data-toggle="modal" data-target="#delete-creation">DELETE</span>
            </div> 
        </div>
        <div class="row add-creation-fields">
            <div class="col-md-8">
            
                <div class="creat-custom-width">   
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title" class="c-1">Title <span id="count"></span></label>
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
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
                        {!! Form::select('sel-int', $interests->lists('title', 'id'), $creation->interest_id, ['class' => 'form-control']) !!}
                        
                        {!! $errors->first('sel-int', '<span class="help-block">:message</span>') !!}
                    </div>

                </div> 
                    
                <div class="form-group {{ $errors->has('desc') ? 'has-error' : '' }}">
                    {!! Form::label('desc', 'Description ') !!}
                    {!! Form::textarea('desc', $creation->description?:null, ['class' => 'form-control', 'rows' => '5']) !!}
                    {!! $errors->first('desc', '<span class="help-block">:message</span>') !!}
                </div>
                    
                <div class="creation-pic" id="editImage1">
                    <p>Featured Images - Add up to three</p>
                    @foreach($creation->userCreationImages->where('featured', '1') as $key=>$image)
                        <div class="imagePreview-3 {{ $errors->has('uploadFile') ? 'has-error' : '' }}" style="background-image:url({{ url('/') }}/uploads/creation/thumb/{{ $image->image }}) !important">
                            <div class="show-on-hover edit-images">
                                <img class="clickForUpload" data-id="{{ $image->id }}" src="{{ url('/') }}/default/images/icons/plus-w.png" width="32" height="32">
                                @if($key != 0)
                                    <img class="clickForDelete" data-id="{{ $image->id }}" src="{{ url('/') }}/default/images/icons/close-w.png" width="32" height="32" data-creation-key="{{ $count }}" data-creation-id="{{ $creation->id }}">
                                @endif
                            </div>
                        </div>
                        {!! Form::file('uploadFile', ['class'=>'uploadFile img', 'id'=>'uploadFile_'.$count, 'accept'=>'image/*']) !!}
                        {!! $errors->first('uploadFile.'.$count, '<span class="help-block">:message</span>') !!}
                        
                        <?php $count++; ?>
                    @endforeach
                    <!-- Add More if the Images are less than 3 -->
                    @if($count < 4)
                        <div class="imagePreview" id="topImagePreview">
                            <div class="show-on-hover">
                                <img src="{{ url('/') }}/default/images/icons/plus-w.png" width="32" height="32" data-count-images="{{ $count-1 }}">
                            </div>
                        </div>
                        {!! Form::file('uploadFileEdit[]', ['class'=>'uploadFile img', 'multiple'=>'true', 'id'=>'uploadFileEdit', 'accept'=>'image/*', 'data-creation-id'=>$creation->id]) !!}
                        {!! $errors->first('uploadFileEdit[]', '<span class="help-block">:message</span>') !!}
                    @endif
                </div>
                <div class="creation-pic" id="editImage2">
                    <p>Other Images</p>    
                    @foreach($creation->userCreationImages->where('featured', '0') as $image)
                        <div class="imagePreview-2 {{ $errors->has('uploadFile') ? 'has-error' : '' }}" style="background-image:url({{ url('/') }}/uploads/creation/thumb/{{ $image->image }}) !important">
                            <div class="show-on-hover edit-images">
                                <img class="clickForUpload" data-id="{{ $image->id }}" src="{{ url('/') }}/default/images/icons/plus-w.png" width="32" height="32">
                                <img class="clickForDelete" data-id="{{ $image->id }}" src="{{ url('/') }}/default/images/icons/close-w.png" width="32" height="32">
                            </div>
                        </div>
                        {!! Form::file('uploadFile', ['class'=>'uploadFile img', 'multiple'=>'true', 'id'=>'uploadFile_'.$count, 'accept'=>'image/*']) !!}
                        {!! $errors->first('uploadFile.'.$count, '<span class="help-block">:message</span>') !!}

                        <?php $count++; ?>
                    @endforeach

                    <!-- Add More -->
                    <div class="imagePreview-1">
                        <div class="show-on-hover">
                            <img src="{{ url('/') }}/default/images/icons/plus-w.png" width="32" height="32">
                        </div>
                    </div>
                    {!! Form::file('uploadFileEdit1[]', ['class'=>'uploadFile img', 'multiple'=>'true', 'id'=>'uploadFileEdit1', 'accept'=>'image/*', 'data-creation-id'=>$creation->id]) !!}
                    {!! $errors->first('uploadFileEdit1[]', '<span class="help-block">:message</span>') !!}
                </div>
                    
            </div>    
            <div class="col-md-4"></div>    
        </div>
        <div class="edit-cre-btn-row">
            <button type="submit" id="createSave" class="btn btn-default btn-md btn-add-create">UPDATE</button>
        </div>
    {!! Form::close() !!}

    <div class="modal fade" id="delete-creation" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <p class="modal-title">Are you sure you want to delete this Creation?</p>
                    <h4 style="color: red;"></h4>
                </div>
                {!! Form::open(['url'=>url('/').'/creation/'.Request::segment(2), 'method' => 'delete']) !!}
                    <div class="modal-body">
                        <div class="text-right">
                            <button type="button" class="btn btn-default btn-modal" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-default btn-modal">Yes</button>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!-- <div class="modal-footer">
                    <a class="btn btn-danger" data-dismiss="modal">Close</a>
                </div> -->
            </div>
        </div>
    </div>
    @include('layouts.partials._popUpLoader')
@endsection
@section('customJsFiles')
    <script src="{{ URL::asset('default/js/editCreations.js') }}"></script>
@endsection