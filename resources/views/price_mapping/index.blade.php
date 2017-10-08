@extends('layouts.app')

@section('content')

@php 
    $i=1;
    $dayTypes = dayTypes();
@endphp


<div class="card">
    <div class="card-header">
        <h2>Price Mapping List</h2>
    </div>

   <div class="card-body card-padding">
    <div class="row">
         <button class="btn bgm-blue waves-effect float-right" onclick="window.location.href='/price-mapping/create/'">Create Booking Types</button>
        </div>
        <br/>
    
    <div class="table-responsive">
        <table id="data-table-basic" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric">ID</th>
                    <th data-column-id="sender">Mapping Details</th>
                    <th data-column-id="sender">Price</th>
                    <th data-column-id="sender">Day Type</th>
                    <th data-column-id="received" data-order="desc">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($priceMappings as $pm) 
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $pm->name }}</td>
                    <td>{{ $pm->price }}</td>
                    <td>{{ $dayTypes[$pm->day_type] }}</td>
                    <td><a href='/price-mapping/{{ $pm->id }}/edit/'>Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
