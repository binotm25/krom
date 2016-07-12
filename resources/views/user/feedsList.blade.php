@extends('layouts.user')

@section('title')
    Feed List
@endsection

@section('content')

<!-- -->
<section class="feeds-posts-endless-paginate" data-next-page="{{ $nextPage == true ? $creations->nextPageUrl() : ''}}">
    @if($creations->count() > 0)
        @foreach($creations as $creation)
            <div class="timeline-details">
                <div class="row timeline">       
                    <div class="col-md-8 user-info">
                        <ul>
                            <li>
                                <a href="{{ route('profile_page', ['user'=>md5(rand(9999,0000)).strrev($creation->user->id)]) }}">
                                    <span>
                                        @if($creation->user->profile_pic)
                                        <img src="{{URL::asset('default/images/people/'.$creation->user->profile_pic)}}" width="33" height="33">
                                        @else
                                        <img src="{{URL::asset('default/images/people/user.png')}}" width="33" height="33">
                                        @endif
                                    </span> {{ $creation->user->name }}
                                </a>
                            </li>
                        </ul>    
                        <h3>
                            <a href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($creation->id)]) }}">
                                {{ $creation->title }}
                            </a>
                        </h3>
                        <h5>
                            <a href="">{{ $creation->location }} 
                                <span class="timeline-date">{{ $creation->created_at->format('M d') }} </span>
                            </a>
                        </h5> 
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
                <div class="row timeline-img">
                    @foreach($creation->userCreationImages->where('featured', 1) as $creationImage)
                        <div class="col-md-4 feed-cust-row">
                            <img class="center-block" src="{{ URL::asset('uploads/creation/thumb/'.$creationImage->image) }}" height="210" alt="post">
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
                                @foreach($creation->praise->sortByDesc('created_at')->take(2) as $praiseId)    
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
                                        <a class="praised-more" data-id="{{ md5(rand(9999,0000)).strrev($creation->id) }}">
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
                        <a href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($creation->id)]) }}"><img src="{{URL::asset('default/images/icons/dots.png')}}" width="28" alt="kritish dots"></a>
                    </div>        
                </div>
            </div>
        @endforeach
    @else
        <div class="timeline-details">
            <div class="row timeline">       
                <div class="col-md-12 feedlistError text-center">
                    <div class="feed-cust-row">
                        <h3>You have yet to showcase your creations. <a href="{{ route('creation_add') }}">Go inspire the world!</a></h3>
                        <p>Hint: Click on the add button on top to add a creation</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
<div id="pageLoaderAnimation">
    <div class='uil-ring-css center-block' style='transform:scale(0.15);'><div></div></div>
</div>
<br /><br />
@endsection
@section('customJsFiles')
    <script src="{{ URL::asset('default/js/feedsIndefiniteScroll.js') }}"></script>
@endsection