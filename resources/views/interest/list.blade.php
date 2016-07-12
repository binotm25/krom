@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <a href="{{ url('/admin/interest/add') }}" type="button" class="btn btn_5 btn-lg btn-primary">ADD</a>    
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($interestData as $interest)
            <tr>
                <td>{{ $interest->title }}</td>
                <td>{{ $interest->status }}</td>
                <td><a href="{{ url('/admin/interest/edit/'.$interest->id) }}"><span class="fa fa-pencil"></span></a></td>
                <td><a href="{{ url('/admin/interest/delete/'.$interest->id) }}" class="x-table">X</a></td>
            </tr>   
            @endforeach
        </tbody>
    </table>

</div>

<div class="clearfix"> </div>
@endsection
