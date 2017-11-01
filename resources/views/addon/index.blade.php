@extends('layouts.app')

@section('content')

@php 
    $i=1;
    $dayTypes = dayTypes();
@endphp


<div class="card">
    <div class="card-header">
        <h2>Extras</h2>
    </div>
    
   <div class="card-body card-padding">
    <div class="row">
         <button class="btn bgm-blue waves-effect float-right" onclick="window.location.href='/addon/create/'">Create Extras</button>
        </div>
        <br/>

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
                    <td>{{ number_format($addon->price,2) }}</td>
                    <td><a href='/addon/{{ $addon->id }}/edit/'>Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
