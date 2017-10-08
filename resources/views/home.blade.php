@extends('layouts.app')

@section('content')

<!--
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
-->

    <div class="row">
        <div class="col-sm-12">
            <!-- Recent Items -->
            <div class="card">
                <div class="card-header">
                    <h2>Recent Bookings</h2>
                </div>
                
                <div class="card-body m-t-0">
                    <table class="table table-inner table-vmiddle">
                        <thead>
                            <tr>
                                <th>Booking Hall</th>
                                <th>Date</th>
                                <th style="width: 20%">Booking Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $key => $value)
                                <tr>
                                    <td class="f-500 c-cyan">{{$value->name}}</td>
                                    <td>{{$value->b_date}}</td>
                                    <td class="f-500 c-cyan">{{$value->total}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
