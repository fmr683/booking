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
                    <h2>Search Existing Bookings</h2>
                </div>
                
                <div class="card-body m-t-0">
                 <div class="card-body card-padding">
                    <form method="GET" action="/">
                        <div class="row">
                            <div class="col-sm-4">
                            <div class="form-group fg-line">
                                <input type="text" name="sdate" value="{{ $rarray['sdate'] or ''}}" placeholder="Start date"  class="form-control date-picker" id="sdate" required>
                            </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="fg-line">
                                    <input type="text" name="edate" value="{{ $rarray['edate'] or ''}}" placeholder="End date"  class="form-control date-picker" id="edate" required>
                            </div>
                            </div>
                            <div class="col-sm-4">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn bgm-orange btn-sm m-t-10">Search</button>
                                <button type="button" onclick="window.location.href='/'"  class="btn bgm-black btn-sm m-t-10">Reset</button>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                    </form>
                    </div>
                     <div class="card-header">
                        <h2>Recent Bookings</h2>
                    </div>
                    @if (empty($bookings[0]))
                        <div class="card-body card-padding"> <h3>{{ 'Sorry No Reocords Were Found' }}</h3></div>
                    @else
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
                                        <td class="f-500 c-cyan">{{number_format($value->total,2)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
