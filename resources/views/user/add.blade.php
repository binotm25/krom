@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <div class="panel-body3">
        <form role="form" class="form-horizontal" method="POST" action="{{ url('/admin/user/save') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn_5 btn-lg btn-primary sub-btn">Submit</button>
            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input value="{{ old('name') }}" name='name' type="text" class="form-control1" placeholder="Name" pattern="[a-zA-Z\s]+" title="Enter Only Alphabet">
                    </div>
                </div>
                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-envelope-o"></i>
                        </span>
                        <input value="{{ old('email') }}"  name='email' type="email" class="form-control1" placeholder="Email Address">
                    </div>
                </div>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-key"></i>
                        </span>
                        <input name='password' type="password" class="form-control1" id="exampleInputPassword1" placeholder="Password">
                    </div>
                </div>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-building"></i>
                        </span>
                        <input value="{{ old('city') }}"  name='city' type="text" class="form-control1" placeholder="City">
                    </div>
                </div>
                @if ($errors->has('city'))
                <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
                @endif
            </div>            

            <div class="form-group">
                <div class="col-md-8">
                    <div class="input-group">							
                        <span class="input-group-addon">
                            <i class="fa fa-location-arrow"></i>
                        </span>
                        <input value="{{ old('zipCode') }}"  name='zipCode' type="number" class="form-control1" placeholder="ZIP">
                    </div>
                </div>
                @if ($errors->has('zipCode'))
                <span class="help-block">
                    <strong>{{ $errors->first('zipCode') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Country</p>
                    <select name="country"  class="form-control1">
                        <option value=''>Country</option>
                        @foreach($countryData as $country)
                        <option value='{{ $country->country_code }}'>{{ $country->country_name }}</option>                        
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Interests</p>
                    <select name='interests[]' multiple="" class="form-control1">
                        @foreach($interestData as $interest)
                        <option value='{{ $interest->id }}'>{{ $interest->title }}</option>                        
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Profile Picture</p>
                    <input name='profilePic' type="file" id="exampleInputFile">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>Cover Picture</p>
                    <input name='coverPic' type="file" id="exampleInputFile">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>My Story</p>
                    <textarea name="myStory" id="txtarea1" cols="50" rows="4" class="form-control1"></textarea></div>
            </div>
            <div class="form-group">
                <div class="col-sm-8 label-text">
                    <p>My Work My Life</p>
                    <textarea name="myWorkMyLife" id="txtarea1" cols="50" rows="4" class="form-control1"></textarea></div>
            </div>
        </form>

    </div>
</div>
<div class="clearfix"> </div>
@endsection
