@extends('layouts.user')

@section('title')
    My Collaboration
@endsection

@section('content')
    <h1>MY COLLABORATIONS</h1>
    <div class="collab-tabs-row">    
        <ul class="nav nav-tabs centered">
            <li class="collab-tab-1 active"><a data-toggle="tab" href="#inbox">Received</a></li>
            <li class="collab-tab-2"><a data-toggle="tab" href="#sent">Sent</a></li>
        </ul>
    
        <div class="tab-content">
            <div id="inbox" class="tab-pane fade in active">
                @if($count > 0)
                    @foreach($creations->reverse() as $crea)
                        @foreach($crea->collaborate as $col)
                            <div class="row inbox-msg">
                                <div class="col-md-1">
                                    <a href="{{ url('/') }}/{{ md5(rand(9999,0000)).strrev($col->user->id) }}/profile"><img src="{{ URL::asset('default/images/people/'.$col->user->profile_pic) }}" class="center-block" width="64" height="64" alt="kritish-profile"></a>
                                </div>
                                <div class="col-md-11">
                                    <h3>{{ $col->user->name }} <span>on {{ $col->created_on->format('M d') }}</span> <span>from {{ $col->user->city }}, {{ $col->user->country->country_name }}</span></h3>
                                    <h4><a class="collaboration-creation-title" href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($crea->id)]) }}">{{ $crea->title }}</a></h4>
                                </div>         
                            </div>
                        @endforeach
                    @endforeach
                @else
                    <div class="row feedlistError text-center">
                        <div class="feed-cust-row">
                            <h3>People are yet to discover your talents, soon you will have a collaboration request here. In the meanwhile keep inspiring people, <a href="{{ route('creation_add') }}" id="wathiWarem">add more creations</a>.</h3>
                        </div>        
                    </div>
                @endif
            </div>
            <div id="sent" class="tab-pane fade in">
                <!-- Message 1 -->
                @if($collaborate->count() > 0)
                    @foreach($collaborate as $cols)
                        <div class="row sent-msg">
                            <div class="col-md-1">
                                <a href="{{ url('/') }}/{{ md5(rand(9999,0000)).strrev($cols->creation->user->id) }}/profile"><img src="{{ URL::asset('default/images/people/'.$cols->creation->user->profile_pic) }}" class="center-block" width="64" height="64" alt="kritish-profile"></a>
                            </div>
                            <div class="col-md-11">
                                <h3>{{ $cols->creation->user->name }} <span>on {{ $cols->created_on->format('M d') }}</span> <span>from {{ $cols->creation->location }}</span></h3>
                                <h4><a class="collaboration-creation-title" href="{{ route('show_creation', ['id'=> md5(rand(9999,0000)).strrev($cols->creation->id)]) }}">{{ $cols->creation->title }}</a></h4>
                            </div>         
                        </div>
                    @endforeach
                @else
                    <div class="row">
                        <div class="col-md-12 feedlistError text-center">
                            <div class="feed-cust-row">
                                <h3>Go ahead find what inspires you And <a href="{{ route('user_feeds') }}">send a collaboration request</a>.</h3>
                            </div>
                        </div>         
                    </div>
                @endif
            </div>    
        </div>
    </div>
@endsection
