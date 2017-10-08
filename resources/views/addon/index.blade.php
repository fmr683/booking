@extends('layouts.app')

@section('content')

@php 
    $i=1;
    $dayTypes = dayTypes();
@endphp


<div class="card">
    <div class="card-header">
        <h2>Addons</h2>
    </div>
    
    <div class="table-responsive">
        <table id="data-table-basic" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric">ID</th>
                    <th data-column-id="sender">Name</th>
                    <th data-column-id="sender">Day Type</th>
                    <th data-column-id="sender">Price</th>
                    <th data-column-id="received" data-order="desc">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($addons as $addon) 
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $addon->add_name }}</td>
                    <td>{{ $dayTypes[$addon->day_type] }}</td>
                    <td>{{ $addon->price }}</td>
                    <td><a href='/addon/{{ $addon->id }}/edit/'>Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
