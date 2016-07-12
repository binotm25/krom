@extends('layouts.app')

@section('content')
<div class="graphs">
    <div class="col-md-8 span_4">
        <div class="col_2">
            <div class="box_1">
                <div class="col-md-6 col_1_of_2 span_1_of_2">
                    <a class="tiles_info">
                        <div class="tiles-head red1">
                            <div class="text-center">Collaborations</div>
                        </div>
                        <div class="tiles-body red">{{ $collaborationCount }}</div>
                    </a>
                </div>
                <div class="col-md-6 col_1_of_2 span_1_of_2">
                    <a class="tiles_info tiles_blue">
                        <div class="tiles-head tiles_blue1">
                            <div class="text-center">Creations</div>
                        </div>
                        <div class="tiles-body blue1">{{ $creationCount }}</div>
                    </a>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="box_1">
                <div class="col-md-6 col_1_of_2 span_1_of_2">
                    <a class="tiles_info">
                        <div class="tiles-head fb1">
                            <div class="text-center">Users</div>
                        </div>
                        <div class="tiles-body fb2">{{ $userCount }}</div>
                    </a>
                </div>
                <div class="col-md-6 col_1_of_2 span_1_of_2">
                    <a class="tiles_info tiles_blue">
                        <div class="tiles-head tw1">
                            <div class="text-center">Interest Areas</div>
                        </div>
                        <div class="tiles-body tw2">{{ $InterestCount }}</div>
                    </a>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>
@endsection
