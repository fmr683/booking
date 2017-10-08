@extends('layouts.app')

@section('content')

@php 
    $i=1;
    $dayTypes = dayTypes();
    $bookingStatus = bookingStatus();
@endphp

<style type="text/css">
  .float-right { float: right;}
}
</style>


<div class="card">
    <div class="card-header">
        <h2>Booking List View</h2>
    </div>
    
     <div class="card-body card-padding">
     <div class="row">
         <button class="btn bgm-blue waves-effect float-right" onclick="window.location.href='/booking/create'">Create Booking</button>
        </div>
        <br/>

      <form method="GET" action="/booking/">
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
                 <div class="form-group fg-line" >
                      <select class="chosen" data-placeholder="Choose Booking Status" name="bstatus">
                      <option value="">Booking Status</option>
                      @foreach($bookingStatus as $key => $value)
                        <option value="{{$key}}" {{ ($rarray['bstatus'][0] == $key ? 'selected' : '')}} >{{$value}}</option>
                      @endforeach
                    </select>
                  </div>
            </div>
        </div>
         <div class="row">
            <div class="col-sm-4">
                  <div class="form-group fg-line" >
                      <select class="chosen" data-placeholder="Choose Day Type" name="dtype">
                      <option value="">Day Type</option>
                      @foreach(dayTypes() as $key => $dayType)
                        <option value="{{$key}}" {{ (!empty($priceMapping) && $priceMapping->day_type == $key ? 'selected' : '')  }}>{{$dayType}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn bgm-orange btn-sm m-t-10">Search</button>
                <button type="button" onclick="window.location.href='/booking/'"  class="btn bgm-black btn-sm m-t-10">Reset</button>
            </div>
            <div class="col-sm-4">
            </div>
          </div>
      </form>
     </div>

    <div class="table-responsive">
        <table id="data-table-basic" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric">Booking Id</th>
                    <th data-column-id="sender">Booking Date</th>
                    <th data-column-id="sender">Booking Details</th>
                    <th data-column-id="sender">Day Type</th>
                    <th data-column-id="sender">Customer Name</th>
                    <th data-column-id="sender">Customer Number</th>
                    <th data-column-id="sender">Total Booking Amount</th>
                    <th data-column-id="sender">Paid Amount</th>
                    <th data-column-id="sender">Outstanding</th>
                    <th data-column-id="received" data-order="desc">Action</th>
                </tr>
            </thead>
            <tbody>
             @foreach ($bookings as $booking) 
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>{{ $booking->b_date }}</td>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $dayTypes[$booking->day_type] }}</td>
                    <td>{{ $booking->c_name }}</td>
                    <td>{{ $booking->c_number }}</td>
                    <td>{{ $booking->total }}</td>
                    <td>{{ $booking->amount }}</td>
                    <td>{{ $booking->total - $booking->amount }}</td>

                    <td><a href='/booking/{{ $booking->id }}/edit/'>Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection



<!--
<form method="GET" action="/booking/">
  <input ><br>
  <input >

 <select name="bstatus">
 <option value="">--Booking Status--</option>
@foreach($bookingStatus as $key => $value)
  <option value="{{$key}}" {{ ($rarray['bstatus'][0] == $key ? 'selected' : '')}} >{{$value}}</option>
@endforeach
</select>

<select name="dtype">
<option  value="">--Day Type--</option>
@foreach($dayTypes as $key => $value)
  <option value="{{$key}}" {{ ($rarray['dtype'][0] == $key ? 'selected' : '') }}>{{$value}}</option>
@endforeach
</select>

    <input type="submit" value="Search">
</form>
-->
