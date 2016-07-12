@extends('layouts.user')

@section('content')

<div class="col-md-8 profile-row">
	
 <div class="row">
<div class="col-md-12">
	@if($userData->cover_pic)
	<img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_COVER_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $userData->cover_pic }}" class="cover-pic" alt="kritish-cover-photo">  
	@else
	<!--<img src="default/images/cover/galaxy.jpg" class="cover-pic" alt="kritish-cover-photo"> -->
	@endif	
  

</div>    
</div>
 
<!-- Profile pic -->    
<div class="row profile-pic-row">
<div class="col-md-2">
	@if($userData->profile_pic)
	<img src="{{ URL::to('/') }}/{{ env('UPLOADS_DIRECTORY') }}/{{ env('UPLOADS_PROFILE_DIRECTORY') }}/{{ env('UPLOAD_THUMB_DIRECTORY') }}/{{ $userData->profile_pic }}" class="profile-pic" alt="kritish-profile-pic">    
	@else
	<!--<img src="default/images/people/zeref.png" class="profile-pic" alt="kritish-profile-pic"> -->
	@endif
	
</div>    
<div class="col-md-6">
<h1><a href="{{ url('/editprofile/') }}/{{ Auth::user()->id }}" title="Edit"> {{ $userData->name }}</a></h1>
<h2>{{ $userData->city }}, {{ $userData->country_code }}</h2>    
</div>    
<div class="col-md-4"></div>    
</div>

<!-- Tabs -->
<div class="row profile-tabs-row">
<div class="col-md-12">
<ul class="nav nav-tabs">
  <li class="prof-tab-1 active"><a data-toggle="tab" href="#mycreations">My Creations</a></li>
  <li class="prof-tab-2"><a data-toggle="tab" href="#mystory">My Story</a></li>
</ul>

<div class="tab-content">
  <div id="mycreations" class="tab-pane fade in active">
    
      <!-- Row 1 -->
   <!-- <div class="profile-timeline-details">
    <div class="row profile-timeline">       
    <div class="col-md-8">   
     <h3><a href="">Climbing Roses in my Garden</a></h3>
     <h5><a href="">Richardson, Texas <span class="profile-timeline-date">March 1</span></a></h5>       
    </div>
             
    <div class="col-md-4 text-right">
     <a href="#" class="btn btn-default btn-md btn-profile-timeline">Collaborate</a>   
    </div>
    </div>
        
    <div class="row profile-timeline-img">       
    <div class="col-md-4 profile-cust-row"><img class="center-block" src="default/images/album/paint-1.jpg" height="210" width="246" alt="post"></div>    
    <div class="col-md-4 profile-cust-row"><img class="center-block" src="default/images/album/paint-2.jpg" height="210" width="246" alt="post"></div>    
    <div class="col-md-4 profile-cust-row"><img class="center-block" src="default/images/album/paint-3.jpg" height="210" width="246" alt="post"></div>     
    </div>
    
    <div class="row text-left profile-timeline-interact">       
    <div class="col-xs-8">
    <ul class="user-info">
    <li class="profile-like"><a href="javascript:void()"><span class="fa fa-heart circle-icon"></span></a></li>        
    <li><a href="#"><img src="default/images/people/olivia.jpg" width="29" height="29"></a></li>        
    <li><a href="#"><img src="default/images/people/leo.jpg" width="29" height="29"></a></li>        
    <li><a href="#"><img src="default/images/people/mark.jpg" width="29" height="29"></a></li>        
    <li class="profile-praise"><a data-target="#praised-more" data-toggle="modal"><p><span>22</span> others have praised this</p></a></li>      
    </ul>    
    </div>
        
    <div class="col-xs-4 profile-timeline-more text-right">
    <a href=""><img src="default/images/icons/tag.png" width="28" alt="kritish tag"></a>   
    <a href=""><img src="default/images/icons/dots.png" width="28" alt="kritish dots"></a>   
    </div>         
    </div>
       
    </div> 
      
     
      
       <div class="profile-timeline-details">
    <div class="row profile-timeline">       
    <div class="col-md-8">   
     <h3><a href="">Climbing Roses in my Garden</a></h3>
     <h5><a href="">Richardson, Texas <span class="profile-timeline-date">March 1</span></a></h5>       
    </div>
             
    <div class="col-md-4 text-right">
     <a href="#" class="btn btn-default btn-md btn-profile-timeline">Collaborate</a>   
    </div>
    </div>
        
    <div class="row profile-timeline-img">       
    <div class="col-md-4 profile-cust-row"><img class="center-block" src="default/images/album/paint-1.jpg" height="210" width="246" alt="post"></div>    
    <div class="col-md-4 profile-cust-row"><img class="center-block" src="default/images/album/paint-2.jpg" height="210" width="246" alt="post"></div>    
    <div class="col-md-4 profile-cust-row"><img class="center-block" src="default/images/album/paint-3.jpg" height="210" width="246" alt="post"></div>     
    </div>
    
    <div class="row text-left profile-timeline-interact">       
    <div class="col-xs-8">
    <ul class="user-info">
    <li class="profile-like"><a href="javascript:void()"><span class="fa fa-heart circle-icon"></span></a></li>        
    <li><a href="#"><img src="default/images/people/olivia.jpg" width="29" height="29"></a></li>        
    <li><a href="#"><img src="default/images/people/leo.jpg" width="29" height="29"></a></li>        
    <li><a href="#"><img src="default/images/people/mark.jpg" width="29" height="29"></a></li>        
    <li class="profile-praise"><a data-target="#praised-more" data-toggle="modal"><p><span>22</span> others have praised this</p></a></li>        
    </ul>    
    </div>
        
    <div class="col-xs-4 profile-timeline-more text-right">
    <a href=""><img src="default/images/icons/tag.png" width="28" alt="kritish tag"></a>   
    <a href=""><img src="default/images/icons/dots.png" width="28" alt="kritish dots"></a>   
    </div>         
    </div>   
    </div>  
      -->
      
      
  </div>
  <div id="mystory" class="tab-pane fade">
	  
	  @foreach($userInterestDataObject as $uIDataObject)

		<?php $userInterestIDs = explode(',', $uIDataObject->interest_ids); ?>

	@endforeach
  
     <div class="row profile-about-text">
     <div class="col-md-12">
		 @if($userData->my_story)
			<p>{{$userData->my_story}}</p>
		@endif
     <!--<p>Lorem ipsum dolor sit amet, te habeo principes adversarium mel. Id usu elitr laudem senserit, vis no solet repudiare. Dicunt disputationi an pri. Nam agam tota tollit ne, per eu autem singulis, in has apeirian pertinax postulant. Justo invenire ex eam, et lucilius posidonium temporibus pro.</p>-->
         
     <h3>My Work My Life</h3>
     @if($userData->my_work_my_life)
		<p>{{$userData->my_work_my_life}}</p>
	 @endif
      <!--<p>Lorem ipsum dolor sit amet, te habeo principes adversarium mel. Id usu elitr laudem senserit, vis no solet repudiare. Dicunt disputationi an pri. Nam agam tota tollit ne, per eu autem singulis, in has apeirian pertinax postulant. Justo invenire ex eam, et lucilius posidonium temporibus pro.</p>     
         
     </div>
     </div>
      
     <div class="row profile-interest">
     <div class="col-md-12">
     <h3>My Interest Areas</h3>
                  
         <div class="row profile-sign-row">    
		<div class="form-group">
            
            <div class="col-md-4 cust-prof-row-padding"><label><p>Fashion</p><img src="default/images/interests/fashion.jpg" alt="kritish-fashion" class="img-responsive img-uncheck-3"><input type="checkbox" name="chk1" id="interest-sign" value="int1" class="hidden"></label></div>
            
            <div class="col-md-4 cust-prof-row-padding"><label><p>Photography</p><img src="default/images/interests/photography.jpg" alt="kritish-photography" class="img-responsive img-uncheck-3"><input type="checkbox" name="chk2" id="interest-sign" value="int2" class="hidden"></label></div>
            
            <div class="col-md-4 cust-prof-row-padding"><label><p>Gardening</p><img src="default/images/interests/gardening.jpg" alt="kritish-gardening" class="img-responsive img-uncheck-3"><input type="checkbox" name="chk3" id="interest-sign" value="int3" class="hidden"></label></div>
		</div>
            </div>
         
                 
         <div class="row int-sign-row-2">    
		<div class="form-group">
            
		<div class="col-md-4 cust-prof-row-padding"><div class="kritish-lay"></div><label><p>Painting</p><img src="default/images/interests/painting.jpg" alt="kritish-painting" class="img-responsive img-uncheck-3"><input type="checkbox" name="chk4" id="interest-sign" value="int4" class="hidden"></label></div>
             
            
        <div class="col-md-4 cust-prof-row-padding"><label><p>Travel</p><img src="default/images/interests/travel.jpg" alt="kritish-travel" class="img-responsive img-uncheck-3"><input type="checkbox" name="chk5" id="interest-sign" value="int5" class="hidden"></label></div>
            
		<div class="col-md-4 cust-prof-row-padding"><label><p>Music</p><img src="default/images/interests/music.jpg" alt="kritish-music" class="img-responsive img-uncheck-3"><input type="checkbox" name="chk6" id="interest-sign" value="int6" class="hidden"></label></div>
		</div>
            </div>
         -->
     </div>
     </div>
      
  </div>
</div>    
</div>    
</div> 

</div>
 
@endsection
