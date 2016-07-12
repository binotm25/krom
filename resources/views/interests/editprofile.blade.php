@extends('layouts.user')



@section('content')

<div class="col-md-8 edit-profile-row">

<form role="form" method="POST" action="{{ url('/editprofile/') }}/{{ $userData->id }}" enctype="multipart/form-data">
     {!! csrf_field() !!}
<div class="row submit-row">
<div class="col-md-6"><h1>Edit Profile</h1></div>    
<div class="col-md-6 edit-prof-btn-row"><button type="submit" class="btn btn-default btn-md btn-e-prof">SAVE</button></div>    
</div>    
    <!-- cover pic -->
<div class="row">
<div class="col-md-12">

<div class="edit-cover">
<div class="trans-layer-1"></div>    
@if($userData->cover_pic)
<img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_COVER_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $userData->cover_pic }}" class="cover-pic-2" alt="kritish-cover-photo">
@else
<img src="{{url('/')}}/default/images/cover/galaxy.jpg" class="cover-pic-2" alt="kritish-cover-photo">
@endif
<div class="camera-edit-1"><img src="{{url('/')}}/default/images/icons/camera.png" width="64" height="64" id="coverpic"></div>


<input name='coverPic' type="file" id="filecover">
</div>
    
</div>    
</div>
 
<!-- Profile pic -->    
<div class="row profile-pic-row">
<div class="col-md-3">

<div class="edit-profile-pic">
<div class="trans-layer-2"></div>    
@if($userData->profile_pic)
<img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_PROFILE_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $userData->profile_pic }}" class="profile-pic-2" alt="kritish-profile-pic">
@else
<img src="{{url('/')}}/default/images/people/zeref.png" class="profile-pic-2" alt="kritish-profile-pic">
@endif
<div class="camera-edit-2"><img src="{{url('/')}}/default/images/icons/camera.png" width="50" height="50"  id="profilepic"></div>
<input name='profilePic' type="file" id="fileprofile">
</div>
    
</div>    
   
<div class="col-md-6"></div>
<div class="col-md-3 pwd-link"><p><a href="">Change Password</a></p>  </div>
    
</div>

<!-- Form Row 1-->
<div class="row">    
<div class="col-md-4">
<div class="form-group">
      <label for="editname" class="p-l-1">Name <span class="fa fa-pencil"></span></label>
      <input type="text" class="form-control" id="editname" value="{{ $userData->name }}" name='name'>
      @if ($errors->has('name'))
		{{ $errors->first('name') }}
      @endif
      
    </div>    
</div>

<div class="col-md-4">
<div class="form-group">
      <label for="editemail" class="p-l-2">Email <span class="fa fa-pencil"></span></label>
      <input type="email" class="form-control" id="editemail" value="{{ $userData->email }}" name='email'>
       @if ($errors->has('email'))
		{{ $errors->first('email') }}
      @endif
    </div>    
</div>
    
<div class="col-md-4 pwd-link">
<!--<p><a href="">Change Password</a></p> -->  
</div>       
</div>
    
<!-- Form Row 2-->
<div class="row">    
<div class="col-md-4">
<div class="form-group">
      <label for="editcity" class="p-l-3">City <span class="fa fa-pencil"></span></label>
      <input type="text" class="form-control" id="editcity" value="{{ $userData->city }}" name="city">
    </div>    
</div>

<div class="col-md-4">
<div class="form-group">
      <label for="editcountry" class="p-l-4">Country <span class="fa fa-pencil"></span></label>
      <select name="country_code"  class="form-control">

		<option value=''>Country</option>

		@foreach($countryData as $country)

		<option @if ($country->country_code == $userData->country_code) selected @endif value='{{ $country->country_code }}'>{{ $country->country_name }}</option>                        

		@endforeach

	</select>
      <!--<input type="text" class="form-control" id="editcountry" value="{{ $userData->country_code }}" name="country_code">-->
    </div>    
</div>
    
<div class="col-md-4">
<div class="form-group">
      <label for="editzip" class="p-l-5">Zip Code <span class="fa fa-pencil"></span></label>
      <input type="text" class="form-control" id="editzip" value="{{ $userData->zip_code }}" name="zip_code">
    </div>    
</div>       
</div>

<hr>
    
<!-- Form Row 3-->
<div class="row">    
<div class="col-md-12">
    
<div class="form-group">
      <label for="editstory" class="p-l-6">My Story <span class="fa fa-pencil"></span></label>
       <textarea class="form-control" rows="5" id="editstory" name="my_story">{{ $userData->my_story }}</textarea>
    </div> 
    
<div class="form-group">
      <label for="editlife" class="p-l-7">My Work My Life <span class="fa fa-pencil"></span></label>
       <textarea class="form-control" rows="5" id="editlife" name="my_work_my_life">{{ $userData->my_work_my_life }}</textarea>
    </div> 
    
</div>   
    
      
</div>     
    
</form>
</div>


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

$(document).ready( function() {
  $('#coverpic').click(function(){
    $("#filecover").click();
  });
  $('#profilepic').click(function(){
    $("#fileprofile").click();
  });
});

</script>
@endsection
