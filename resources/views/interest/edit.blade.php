@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <div class="panel-body3">
        <form role="form" class="form-horizontal" method="POST" action="{{ url('/admin/interest/update/') }}/{{ $interestData->id }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn_5 btn-lg btn-primary sub-btn">Submit</button>

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input name='title' value='{{ $interestData->title }}' type="text" class="form-control1" placeholder="Title">
                    </div>
                </div>				@if ($errors->has('title'))                <span class="help-block">                    <strong>{{ $errors->first('title') }}</strong>                </span>                @endif
            </div>            

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Status</p>
                    <select name='status' class="form-control1">
                        <option value='active' @if ($interestData->status == 'active') selected @endif>Active</option>
                        <option value='inactive' @if ($interestData->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Photo</p>
                    <input name='interestPic' type="file" id="exampleInputFile">
                </div>
            </div>

            <img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_INTEREST_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $interestData->image }}" class="img-responsive" width="300" alt="interest-pic">

        </form>

    </div>
</div>
<div class="clearfix"> </div>
@endsection
