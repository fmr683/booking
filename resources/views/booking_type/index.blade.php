@extends('layouts.app')

@section('content')

@php 
    $i=1;
@endphp

<div class="card">
    <div class="card-header">
        <h2>Booking Types</h2>
    </div>

     <div class="card-body card-padding">
     <div class="row">
         <button class="btn bgm-blue waves-effect float-right" onclick="window.location.href='/booking-type/create/'">Create Booking Types</button>
        </div>
        <br/>
    
    <div class="table-responsive">
        <table id="data-table-basic" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric">ID</th>
                    <th data-column-id="sender">Hall Name</th>
                    <th data-column-id="received" data-order="desc">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($bookingTypes as $booking) 
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $booking->name }}</td>
                    <td><a href='/booking-type/{{$booking->id}}/edit/'>Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
