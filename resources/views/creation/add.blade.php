@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <div class="panel-body3">
        {!! Form::open(['role'=>'form', 'files'=>true]) !!}
        <!-- <form role="form" class="form-horizontal" method="POST" action="{{ url('/admin/creation/save') }}" enctype="multipart/form-data"> -->
            <button type="submit" class="btn btn_5 btn-lg btn-primary sub-btn">Submit</button>
            <div class="form-group">
                <div class="col-sm-8 label-text cust-select">
                    <p>User Selection</p>
                    <select name="user_id" id="user_id" class="form-control1">
                        <option value="">Select</option>
                        @foreach($userData as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} < {{ $user->email }} ></option>
                        @endforeach
                    </select>
                </div>
                {!! $errors->first('user_id', '<span class="help-block">:message</span>') !!}
            </div>

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon"><i class="fa fa-newspaper-o"></i></span>
                        {!! Form::text('title', null, ['class'=>'select2 form-control1', 'placeholder'=>'Title', 'maxlength'=>'60']) !!}
                    </div>
                </div>
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>


            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        {!! Form::text('location', null, ['class'=>'form-control1', 'id'=>'city', 'placeholder'=>'Location']) !!}
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Interest Area</p>
                    {!! Form::select('interest', $interestData->lists('title', 'id'), null, ['class'=>'form-control1']) !!}
                </div>
                {!! $errors->first('interest', '<span class="help-block">:message</span>') !!}
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Description</p>
                    {!! Form::textarea('description', null, ['class'=>'form-control1', 'id'=>'textarea1', 'cols'=>'50', 'rows'=>'4']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Featured Photos (Select upto 3)</p>
                    {!! Form::file('featuredPhotos[]', ['multiple'=>'true', 'id'=>'featuredPhotos']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Other Photos</p>
                    {!! Form::file('otherPhotos[]', ['multiple'=>'true', 'id'=>'exampleInputFile']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="clearfix"> </div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#user_id").change(function () {
            var val = $(this).val();
            if (typeof (val) !== "undefined" && val) {
                var APP_URL = {!! json_encode(url('/')) !!};

                /*$.ajax({
                    url: APP_URL  + '/interest/list/byuserid/' + val,
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
                });*/
				
				$.ajax({
                    url: APP_URL  + '/admin/user/city/' + val,
                    data: {
                        format: 'json'
                    },
                    dataType: 'json',
                    type: 'GET',
                    success: function (data) {				
						$('#city').val(data.city);
						$('#city').attr('readonly', true);
                    }
                });
            } else {
                
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
