@extends('layouts.app')



@section('content')

<div class="col-md-12 graphs">

    <div class="panel-body3">

        <form role="form" class="form-horizontal" method="POST" action="{{ url('/admin/user/update') }}/{{ $userData->id }}" enctype="multipart/form-data">

            {!! csrf_field() !!}

            <button type="submit" class="btn btn_5 btn-lg btn-primary sub-btn">Submit</button>

            <div class="form-group">

                <div class="col-md-8">

                    <div class="input-group">							

                        <span class="input-group-addon">

                            <i class="fa fa-user"></i>

                        </span>

                        <input value="{{ $userData->name }}" name='name' type="text" class="form-control1" placeholder="Name" pattern="[a-zA-Z\s]+" title="Enter Only Alphabet">

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

                        <input name="email" value="{{ $userData->email }}"  type="email" class="form-control1" placeholder="Email Address">

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

                            <i class="fa fa-building"></i>

                        </span>

                        <input value="{{ $userData->city }}"  name='city' type="text" class="form-control1" placeholder="City">

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

                        <input value="{{ $userData->zip_code }}"  name='zip_code' type="text" class="form-control1" placeholder="ZIP">

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

                    <select name="country_code"  class="form-control1">

                        <option value=''>Country</option>

                        @foreach($countryData as $country)

                        <option @if ($country->country_code == $userData->country_code) selected @endif value='{{ $country->country_code }}'>{{ $country->country_name }}</option>                        

                        @endforeach

                    </select>

                </div>

            </div>

            <?php $userInterestIDs = array(); ?>

            @foreach($userInterestDataObject as $uIDataObject)

                <?php $userInterestIDs = explode(',', $uIDataObject->interest_ids) ?>

            @endforeach

                  

            <div class="form-group">

                <div class="col-sm-8 label-text">

                    <p>Interests</p>

                    <select name='interests[]' multiple="" class="form-control1">

                        @foreach($interestData as $interest)

                        <option <?php if(in_array($interest->id, $userInterestIDs)) { echo "selected "; } ?>value='{{ $interest->id }}'>{{ $interest->title }}</option>                        

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

            

            <img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_PROFILE_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $userData->profile_pic }}" class="img-responsive" width="300" alt="interest-pic">



            <div class="form-group">

                <div class="col-sm-8 label-text">

                    <p>Cover Picture</p>

                    <input name='coverPic' type="file" id="exampleInputFile">

                </div>

            </div>

            

            <img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_COVER_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $userData->cover_pic }}" class="img-responsive" width="300" alt="interest-pic">



            <div class="form-group">

                <div class="col-sm-8 label-text">

                    <p>My Story</p>

                    <textarea name="my_story" id="txtarea1" cols="50" rows="4" class="form-control1">{{ $userData->my_story }}</textarea></div>

            </div>

            <div class="form-group">

                <div class="col-sm-8 label-text">

                    <p>My Work My Life</p>

                    <textarea name="my_work_my_life" id="txtarea1" cols="50" rows="4" class="form-control1">{{ $userData->my_work_my_life }}</textarea></div>

            </div>

        </form>



    </div>

</div>

<div class="clearfix"> </div>
<script type="text/javascript">
$(document).unbind('keydown').bind('keydown', function (event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ((d.tagName.toUpperCase() === 'INPUT' && 
             (
                 d.type.toUpperCase() === 'TEXT' ||
                 d.type.toUpperCase() === 'PASSWORD' || 
                 d.type.toUpperCase() === 'FILE' || 
                 d.type.toUpperCase() === 'SEARCH' || 
                 d.type.toUpperCase() === 'EMAIL' || 
                 d.type.toUpperCase() === 'NUMBER' || 
                 d.type.toUpperCase() === 'DATE' )
             ) || 
             d.tagName.toUpperCase() === 'TEXTAREA') {
            doPrevent = d.readOnly || d.disabled;
        }
        else {
            doPrevent = true;
        }
    }

    if (doPrevent) {
        event.preventDefault();
    }
});
</script>
@endsection
