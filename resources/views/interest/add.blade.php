@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <div class="panel-body3">
        <form role="form" class="form-horizontal" method="POST" action="{{ url('/admin/interest/save') }}"  enctype="multipart/form-data">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn_5 btn-lg btn-primary sub-btn">Submit</button>

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input name="name" type="text" class="form-control1" placeholder="Title">
                    </div>
                </div>				@if ($errors->has('name'))                <span class="help-block">                    <strong>{{ $errors->first('name') }}</strong>                </span>                @endif
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Status</p>
                    <select name="status"  class="form-control1">
                        <option value='active'>Active</option>
                        <option value='inactive'>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Photo</p>
                    <input name='interestPic' type="file" id="exampleInputFile">
                </div>
            </div>

            

        </form>

    </div>
</div>
<div class="clearfix"> </div>
@endsection
