@extends('layouts.user')

@section('title')
    Feed List
@endsection

@section('content')

<!-- --> 
    @foreach($creations as $creation)
        <div class="timeline-details">
            <div class="row timeline">       
                <div class="col-md-8 user-info">
                    <ul>
                        <li>
                            <a href="#"><span><img src="{{URL::asset('default/images/people/'.$creation->user->profile_pic)}}" width="33" height="33"></span> {{ $creation->user->name }}</a>
                        </li>
                    </ul>    
                    <h3><a href="">{{ $creation->title }}</a></h3>
                    <h5><a href="">{{ $creation->location }}, {{ $creation->user->country->country_name }} <span class="timeline-date">{{ $creation->created_at->format('M d') }} </span></a></h5> 
                </div>
                <div class="col-md-4 text-right">
                    @if($creation->user->id == Auth::user()->id)
                        <a href="{{ url('/') }}/creation/{{ md5(rand(9999,0000)).strrev($creation->id) }}/edit" class="btn btn-default btn-md btn-timeline">Edit</a>
                    @else
                        @if(in_array($creation->id, $colId))
                            <buttton class="btn btn-default btn-md btn-timeline collaborate">Collaborated</button>
                        @else
                            <a href="{{ URL('/') }}/collaborate/{{ md5(rand(9999,0000)).strrev($creation->id) }}" class="btn btn-default btn-md btn-timeline collaborate">Collaborate</a>
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
                        <li class="like"><a href="javascript:void()"><span class="fa fa-heart circle-icon"></span></a></li>        
                        <li>
                            <a href="#"><img src="{{URL::asset('default/images/people/olivia.jpg')}}" width="29" height="29"></a>
                        </li>        
                        <li>
                            <a href="#"><img src="{{URL::asset('default/images/people/mark.jpg')}}" width="29" height="29"></a>
                        </li>        
                        <li>
                            <a href="#"><img src="{{URL::asset('default/images/people/leo.jpg')}}" width="29" height="29"></a>
                        </li>        
                        <li class="praise">
                            <a data-target="#praised-more" data-toggle="modal"><p><span>22</span> others have praised this</p></a>
                        </li>        
                    </ul>    
                </div>
                <div class="col-xs-4 timeline-more">
                    <a href=""><img src="{{URL::asset('default/images/icons/tag.png')}}" width="30" alt="kritish tag"></a>
                    <a href=""><img src="{{URL::asset('default/images/icons/dots.png')}}" width="28" alt="kritish dots"></a>      
                </div>        
            </div>
        </div>
    @endforeach
@endsection