@extends('layouts.app')

@section('content')

@php 
    $i=1;
@endphp

<div class="card">
    <div class="card-header">
        <h2>Users</h2>
    </div>
    
    <div class="table-responsive">
        <table id="data-table-basic" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric">ID</th>
                    <th data-column-id="sender">User</th>
                    <th data-column-id="received" data-order="desc">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user) 
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $user->name }}</td>
                    <td><a href='/user/{{ $user->id }}/edit/'>Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
