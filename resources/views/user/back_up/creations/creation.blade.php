@extends('layouts.user')

@section('title')
    {{ $creation->title }}
@endsection

@section('content')
    <div class="full-timeline-details">
        <div class="row full-timeline">       
            <div class="col-md-8 user-info">
                <ul><li><a href="{{ route('profile_page', ['user'=>md5(rand(9999,0000)).strrev($creation->user->id)]) }}">
                    <span>
                        <img src="{{ URL::asset('default/images/people/'.$creation->user->profile_pic) }}" width="33" height="33">
                    </span> {{ $creation->user->name }}
                </a></li></ul>    
                <h3><a href="#">{{ $creation->title }}</a></h3>
                <h5><a href="#">
                    {{ $creation->location }}<span class="full-timeline-date"> {{ $creation->created_at->format('M d') }}</span>
                </a></h5>
                <p>{{ $creation->description }}</p>    
            </div>
             
            <div class="col-md-4 text-right">
                @if($creation->user->id == Auth::user()->id)
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
    
        <h2>Featured Images</h2>
        <div class="row full-timeline-img">      
            @foreach($creation->userCreationImages->where('featured', '1') as $images) 
                <div class="col-md-4 detailed-cust-row">
                    <img class="center-block" src="{{ URL::asset('uploads/creation/thumb/'.$images->image) }}" height="220" alt="post">
                </div>    
            @endforeach     
        </div>
    
        <h2>Other Images</h2>
        <div class="row full-timeline-img">
            @foreach($creation->userCreationImages->where('featured', '0') as $images)
                <div class="col-md-4 detailed-cust-row">
                    <img class="center-block" src="{{ URL::asset('uploads/creation/thumb/'.$images->image) }}" height="220" alt="post">
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
                                    @if($praiseId->user->profile_pic == "")
                                        <img src="{{URL::asset('default/images/people/user.png')}}" width="29" height="29">
                                    @else
                                        <img src="{{URL::asset('default/images/people/'.$praiseId->user->profile_pic)}}" width="29" height="29">
                                    @endif
                                </a>
                            </li>
                        @endforeach

                        @if($creation->praise->count() > 2)
                            <li class="full-praise">
                                <a data-target="#praised-more" data-toggle="modal">
                                    <p><span class="data-praiseCount">{{ $creation->praise->count() - 2 }}</span> others have praised this</p>
                                </a>
                            </li>
                        @endif

                    @endif
                </ul>
                </div>
                <div class="col-xs-4 timeline-more tag-info">
                    <a class="tag-text">{{ $interestNames[$creation->interest_id] }}</a>
                    <a href="javascript:void(0);" class="tag-pic"><img src="{{URL::asset('default/images/icons/tag.png')}}" width="30" alt="kritish tag"></a>
                </div>
            </div>
@endsection
