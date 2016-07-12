@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <div class="panel-body3">
        <form role="form" class="form-horizontal" method="POST" action="{{ url('/admin/creation/update') }}/{{ $creationData->id }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn_5 btn-lg btn-primary sub-btn">Submit</button>


            <div class="form-group">
                <div class="col-sm-8 label-text cust-select">
                    <p>User Selection</p>							
                    <select disabled="true" class="form-control1">
                        <option value="">Select</option>	
						<?php if($userData) { ?>
                        @foreach($userData as $user)
                        <option @if ($creationData->user_id == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }} < {{ $user->email }} ></option>
                        @endforeach
						<?php } ?>
                    </select>
                </div>
                @if ($errors->has('user_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
                @endif
            </div>
			@foreach($userData as $user)
			<input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}" />
			@endforeach

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-newspaper-o"></i>
                        </span>
                   <input value="{{ $creationData->title }}" name="title" type="text" class="form-control1" placeholder="Title" maxlength="60">
                    </div>
                </div>
                @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
            </div>


            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-building"></i>
                        </span>
                        <input readonly value="{{ $creationData->location }}" name="location" type="text" class="form-control1" placeholder="Location">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Interest Area</p>
                    
                    <select name="interest" id="interest" class="form-control1">
                        <option value="">Select</option>    
                        @foreach($userInterestData as $uiData)
                        <option @if ($uiData['id'] == $creationData->interest_id) selected @endif value="{{ $uiData['id'] }}">{{ $uiData['title'] }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('interest'))
                <span class="help-block">
                    <strong>{{ $errors->first('interest') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Description</p>
                    <textarea name="description" id="txtarea1" cols="50" rows="4" class="form-control1"> {{ $creationData->description }} </textarea></div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Featured Photos (Select upto 3)</p>
                    <input name="featuredPhotos[]" type="file" id="featuredPhotos" multiple max-uploads=3>
                </div>
            </div>
            
            @foreach($userCreationImages as $uiImage)
                @if($uiImage->featured == 1)
                    <img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_CREATION_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $uiImage->image }}" class="img-responsive" width="300" alt="interest-pic">
                @endif
            @endforeach
            

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Other Photos</p>
                    <input name="otherPhotos[]" type="file" id="exampleInputFile" multiple>
                </div>
            </div>
            
            @foreach($userCreationImages as $uiImage)
                @if($uiImage->featured == 0)
                    <img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_CREATION_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $uiImage->image }}" class="img-responsive" width="300" alt="interest-pic">
                @endif
            @endforeach

        </form>

    </div>
</div>
<div class="clearfix"> </div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#user_id").change(function () {
            var val = $(this).val();
            if (typeof (val) !== "undefined" && val) {
                $.ajax({
                    url: '/admin/interest/list/byuserid/' + val,
                    data: {
                        format: 'json'
                    },
                    dataType: 'json',
                    type: 'GET',
                    success: function (data) {
                        $('#interest').empty();
                        $('#interest').append($('<option>').text("Select"));
                        $.each(data, function (i, obj) {
                            $('#interest').append($('<option>').text(obj.text).attr('value', obj.val));
                        });
                    },
                });
            } else {
                $('#interest').empty();
                $('#interest').append($('<option>').text("Select"));
            }
        });
		
		$("#featuredPhotos").change(function() {
			if(this.files.length >3) {
				alert('Allowed only 3 featured photos!');
			}
		});
		
		$('form').submit(function(){		
			if($("#featuredPhotos").get(0).files.length>3) {
				alert('Allowed only 3 featured photos!');
				return false;
			}			
		});
    });
</script>
@endsection

