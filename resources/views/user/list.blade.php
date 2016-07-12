@extends('layouts.app')

@section('content')
<div class="col-md-12 graphs">
    <a href="{{ url('/admin/user/add') }}" type="button" class="btn btn_5 btn-lg btn-primary">ADD</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Country</th>
                <th>Password</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($userData as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->city }}</td>
                <td>{{ $user->country_code }}</td>
                <td><a href="{{ url('/admin/user/edit-password/'.$user->id) }}"><span class="fa fa-pencil"></span></a></td>
                <td><a href="{{ url('/admin/user/edit/'.$user->id) }}"><span class="fa fa-pencil"></span></a></td>
                <td><a href="{{ url('/admin/user/delete/'.$user->id) }}}" class="x-table">X</a></td>
            </tr>    
            @endforeach
        </tbody>
    </table>

</div>
<div class="clearfix"> </div>
@endsection
