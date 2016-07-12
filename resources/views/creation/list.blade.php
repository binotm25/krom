@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <a href="{{ url('/admin/creation/add') }}" type="button" class="btn btn_5 btn-lg btn-primary">ADD</a>    
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Interest</th>
                <th>Location</th>
                <th>User</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($creationData as $creation)            
            <tr>
                <td>{{ $creation->title }}</td>
                <td>
                    {{ $creation['interest']['title'] }}
                </td>
                <td>{{ $creation->location }}</td>
                <td>{{ $creation['user']['name'] }}</td>
                <td><a href="{{ url('/admin/creation/edit/'.$creation->id) }}"><span class="fa fa-pencil"></span></a></td>
                <td><a href="{{ url('/admin/creation/delete/'.$creation->id) }}" class="x-table">X</a></td>
            </tr>   
            @endforeach
        </tbody>
    </table>

</div>

<div class="clearfix"> </div>
@endsection
