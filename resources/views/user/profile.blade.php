@extends('layouts.user')

@section('title')
    {{ $userData->name }}'s Profile
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($userData->cover_pic)
                <img src="{{ URL::asset('uploads/cover/'.$userData->cover_pic) }}" class="cover-pic" alt="kritish-cover-photo"> 
            @else
                <img src="{{ URL::asset('default/images/cover/galaxy.jpg') }}" class="cover-pic" alt="kritish-cover-photo">
            @endif
        </div>    
    </div>
 
    <!-- Profile pic -->    
    <div class="row profile-pic-row">
        <div class="col-md-2">
            @if($userData->profile_pic)
                <img src="{{ URL::asset('default/images/people/'.$userData->profile_pic) }}" class="profile-pic" alt="kritish-profile-pic">
            @else
                <img src="{{ URL::asset('default/images/icons/user.png') }}" class="profile-pic" alt="kritish-profile-pic">
            @endif
        </div>    
        <div class="col-md-6">
            <h1>{{ $userData->name }}</h1>
            <h2>{{ $userData->city }}, {{ $userData->country->country_name }}</h2>    
        </div>    
        <div class="col-md-4 pwd-link">
            @if($isAuthUser)
                <p><a href="{{ route('edit_profile') }}">Edit Profile</a></p>
            @endif
        </div>    
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
                    <div class="profile-timeline-details">
                        @foreach($creations as $creation)
                            <div class="row profile-timeline">       
                                <div class="col-md-8">   
                                    <h3><a href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($creation->id)]) }}">{{ $creation->title }}</a></h3>
                                    <h5><a href="#">{{ $userData->city }}, {{ $userData->country->country_name }} <span class="profile-timeline-date">{{ $creation->created_at->format('M d') }}</span></a></h5>       
                                </div>
                                <div class="col-md-4 text-right">
                                    @if($isAuthUser == Auth::user()->id)
                                        <a href="{{ route('creation_edit', ['id'=> md5(rand(9999,0000)).strrev($creation->id) ]) }}" class="btn btn-default btn-md btn-timeline">Edit</a>
                                    @else
                                        @if(in_array($creation->id, $colId))
                                            <buttton class="btn btn-default btn-md btn-timeline collaborate">Collaborated</button>
                                        @else
                                            <a href="{{ route('collaborate', ['id'=> md5(rand(9999,0000)).strrev($creation->id) ]) }}" class="btn btn-default btn-md btn-timeline collaborate">Collaborate</a>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="row profile-timeline-img"> 
                                @foreach($creation->userCreationImages->where('featured', '1') as $creationImage)      
                                    <div class="col-md-4 profile-cust-row">
                                        <img class="center-block" src="{{ URL::asset('uploads/creation/thumb/'.$creationImage->image) }}" height="210" width="246" alt="post">
                                    </div>  
                                @endforeach  
                            </div>

                            <div class="row text-left timeline-interact">       
                                <div class="col-xs-8">
                                    <ul class="user-info">
                                        <li class="like" data-id={{ md5(rand(9999,0000)).strrev($creation->id) }}>
                                            <span class="fa fa-heart circle-icon" style="{{ in_array($creation->id, $praise) ? 'color:red;' : '' }}">
                                            </span>
                                        </li>
                                        @if($creation->praise->count() == 0)
                                            <li class="if-praise"></li>
                                        @else
                                            @foreach($creation->praise->reverse()->take(2) as $praiseId)    
                                                <li class="if-praise" data-praise="{{ $praiseId->id }}">
                                                    <a href="{{ route('profile_page', ['user'=>md5(rand(9999,0000)).strrev($praiseId->user->id)]) }}" data-toggle="tooltip" data-placement="right" title="{{ $praiseId->user->name }}">
                                                        <img src="{{URL::asset('default/images/people/'.$praiseId->user->profile_pic)}}" width="29" height="29">
                                                    </a>
                                                </li>
                                            @endforeach

                                            @if($creation->praise->count() > 2)
                                                <li class="full-praise">
                                                    <a class="praised-more" data-id="{{ md5(rand(9999,0000)).strrev($creation->id) }}">
                                                        <p><span class="data-praiseCount">{{ $creation->praise->count() - 2 }}</span> others have praised this</p>
                                                    </a>
                                                </li>
                                            @endif

                                        @endif
                                    </ul>
                                </div>
            
                                <div class="col-xs-4 profile-timeline-more text-right tag-info">
                                    <a class="tag-text">{{ $interestNames[$creation->interest_id] }}</a>
                                    <a href="javascript:void(0);" class="tag-pic"><img src="{{URL::asset('default/images/icons/tag.png')}}" width="30" alt="kritish tag"></a> 
                                    <a href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($creation->id)]) }}"><img src="{{ URL::asset('default/images/icons/dots.png') }}" width="28" alt="kritish dots"></a>   
                                </div>         
                            </div>
                        @endforeach
                    </div>  
                </div>
                
                <div id="mystory" class="tab-pane fade">
   
                    <div class="row profile-about-text">
                        <div class="col-md-12">
                            <p>{{ $userData->my_story }}</p>
         
                            <h3>My Work My Life</h3>
                            <p>{{ $userData->my_work_my_life }}</p>     
         
                        </div>
                    </div>
      
                    <div class="row profile-interest">
                        <div class="col-md-12">
                            <h3>My Interest Areas</h3>
                            <!-- Interest Row 1 -->
                            <div class="row profile-sign-row">    
                                <div class="form-group">
                                    @foreach($interests as $interest)
                                        <div class="col-md-4 cust-prof-row-padding">
                                            <label>
                                                <p>{{ $interest->title }}</p>
                                                <img src="{{ URL::asset('default/images/interests/'.$interest->image) }}" alt="kritish-fashion" class="img-responsive img-uncheck-3"><input type="checkbox" name="chk1" id="interest-sign" value="int1" class="hidden">
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>         
                        </div>
                    </div>
      
                </div>
            </div>    
        </div>    
    </div>
@endsection
