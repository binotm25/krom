@extends('layouts.user')

@section('title')
    {{ $data }}'s Search Results
@endsection

@section('content')
    {!! Form::open(['route'=>'creation_search', 'class'=>'search-row', 'role'=>'form']) !!}
        <div class="row">
            <div class="col-md-6 search-bar">
                <div class="input-group">
                    {!! Form::text('search', $data, ['class'=>'form-control search-form', 'placeholder'=>'Search']) !!}
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default search-btn" data-target="#search-form" name="q">
                            <i class="fa fa-search" style="height: 16px;"></i>
                        </button>
                    </span>
                </div>
            </div>    
             
        </div>
    {!! Form::close() !!}
    
    <div class="row cate-row">

        <div class="col-md-12">
            <ul>
                <li id="show_all">
                    <img src="{{ URL::asset('default/images/icons/tag.png') }}" width="30" alt="search-tag-image">
                </li>
                @foreach($countMasing as $key=>$value)
                    <li data-interest-key="{{ $key }}">
                        <p>{{ $interestNames[$key] }} ({{ $value }}) 
                            <span><img src="{{ URL::asset('default/images/icons/close-b-b.png') }}" alt="close" width="18"></span>
                        </p>
                    </li>
                @endforeach
                <li>
                    <img src="{{ URL::asset('default/images/icons/arrow-right-2.png') }}" alt="close" width="15">
                </li>
            </ul>    
        </div>
    </div>
        
    <hr>    
        
    <!-- Row 1 -->
    @if($items->count() == 0)
        <h3>Sorry No Results Found for "{{ $data }}". Please try another.</h3>
    @else
        @foreach($items as $item)
            <div class="search-timeline-details" data-interest-key="{{ $item->interest_id }}">

                <div class="row search-timeline">       
                    <div class="col-md-8">   
                        <h3><a href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($item->id)]) }}">{{ $item->title }}</a></h3>
                        <h5><a href="">{{ $item->location }} <span class="timeline-date">{{ $item->created_at->format('M d') }} </span></a></h5>        
                    </div>
                         
                    <div class="col-md-4 text-right">
                        @if($item->user->id == Auth::user()->id)
                            <a href="{{ url('/') }}/creation/{{ md5(rand(9999,0000)).strrev($item->id) }}/edit" class="btn btn-default btn-md btn-timeline">Edit</a>
                        @else
                            @if(in_array($item->id, $colId))
                                <buttton class="btn btn-default btn-md btn-timeline collaborate">Collaborated</button>
                            @else
                                <a href="{{ URL('/') }}/collaborate/{{ md5(rand(9999,0000)).strrev($item->id) }}" class="btn btn-default btn-md btn-timeline collaborate">Collaborate</a>
                            @endif
                        @endif  
                    </div>
                </div>
                    
                <div class="row search-timeline-img"> 
                    @foreach($item->userCreationImages->where('featured', 1) as $creationImage)
                        <div class="col-md-4 feed-cust-row">
                            <img class="center-block" src="{{ URL::asset('uploads/creation/thumb/'.$creationImage->image) }}" height="220" width="256" alt="post">
                        </div>  
                    @endforeach    
                </div>
                
                       
                <div class="row text-left search-timeline-interact">     
                    <div class="col-xs-8">
                        <ul class="user-info">
                            <li class="like" data-id={{ md5(rand(9999,0000)).strrev($item->id) }}>
                                <span class="fa fa-heart circle-icon" style="{{ in_array($item->id, $praise) ? 'color:red;' : '' }}">
                                </span>
                            </li>
                            @if($item->praise->count() == 0)
                                <li class="if-praise"></li>
                            @else
                                @foreach($item->praise->reverse()->take(2) as $praiseId)    
                                    <li class="if-praise" data-praise="{{ $praiseId->id }}">
                                        <a href="{{ route('profile_page', ['user'=>md5(rand(9999,0000)).strrev($praiseId->user->id)]) }}">
                                            <img src="{{URL::asset('default/images/people/'.$praiseId->user->profile_pic)}}" width="29" height="29">
                                        </a>
                                    </li>
                                @endforeach
    
                                @if($item->praise->count() > 2)
                                    <li class="full-praise">
                                        <a class="praised-more" data-id="{{ md5(rand(9999,0000)).strrev($item->id) }}">
                                            <p><span class="data-praiseCount">{{ $item->praise->count() - 2 }}</span> others have praised this</p>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-4 profile-timeline-more text-right">
                        <a class="tag-text">{{ $interestNames[$item->interest_id] }}</a>
                        <a href="javascript:void(0);" class="tag-pic"><img src="{{URL::asset('default/images/icons/tag.png')}}" width="30" alt="kritish tag"></a>   
                        <a href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($item->id)]) }}"><img src="{{ URL::asset('default/images/icons/dots.png') }}" width="28" alt="kritish dots"></a>   
                    </div>
                </div>        
            </div>
        @endforeach
    @endif
@endsection
@section('customJsFiles')
    <script src="{{ URL::asset('default/js/search.js') }}"></script>
@endsection