
@extends('layouts.app')

@section('content')

@php
$paid = 0.00;
$bookingStatus = bookingStatus();
$sno=1;
@endphp

<style type="text/css">
  .pad { padding: 10px; }
  .alert h4 { margin-bottom: 0px; }

  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>

<div class="card">
    <div class="card-header">
        <h2>Add/Edit Booking</h2>
    </div>
    <div class="card-body card-padding">

      {!! Form::open(array('route' => array($action["action"], (!empty($booking->id) ? $booking->id : '' )),
      'class' => 'form', 'method' => $action["method"])) !!}

          <div class="alert alert-warning warning" role="alert" style="display: none">There few overlapping booking exist with the selected Halls</div>

<div class="alert  alert-info alert-dismissible" role="alert">
   <h4>Booking Information</h4>
</div>

      <div class="form-group fg-line">
        <label for="name">Date</label>
        <input type="text"  name="b_date" value="{{ $booking->b_date or '' }}" class="form-control date-picker" id="b_date" placeholder="Booking Date" required>
      </div>

      <div class="form-group fg-line" >
          <select class="form-control pad"name="day_type" id="day_type" required>
            <option value="">-- Select Day Type --</option>
           @foreach(dayTypes() as $key => $dayType)
            <option value="{{$key}}" {{ (!empty($booking) && $booking->day_type == $key ? 'selected' : '')  }}>{{$dayType}}</option>
          @endforeach
        </select>
      </div>


       <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Hall</p>
          <select name="pm_id" id="pm_id" class="form-control pad" required>
           <option value="">-- Select Hall --</option>
        </select>
      </div>



    <div class="form-group fg-line" >
      <p class="f-500 c-black m-b-15">Addons</p>
        <div id="addon">
          @if (!empty($booking->id)) 
            @foreach($addons as $key => $value) 
              <label class="checkbox-inline"><input 

                @foreach($bookingAddons as $bakey => $bavalue)
                  {{($bavalue->addon_id == $value->id ? 'checked': '')}}
                @endforeach

              type='checkbox' class='addon' value='{{$value->id}}' name='addon[]' data-addon-price='{{$value->price}}'>{{$value->add_name}}</label>
            @endforeach
          @endif
        </div>
    </div>
   
   <br/>
   <div class="alert  alert-info alert-dismissible" role="alert">
      <h4>Booking Price Information</h4>
    </div>

      <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Hall Amount</p>
          <p class="f-500 c-red m-b-15" id="pm_amount">{{ $booking->h_total or '0.00' }}</p>
          <input type="hidden" name="h_total"  step=".01" id='h_total'  value="{{ $booking->h_total or '0.00' }}">
      </div>

      <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Addon Amount</p>
          <p class="f-500 c-red m-b-15" id="addon_amount">{{ $booking->add_total or '0.00' }}</p>
          <input type="hidden" name="add_total"  step=".01" id='add_total'  value="{{ $booking->add_total or '0.00' }}">
      </div>


       <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Total Amount</p>
          <p class="f-500 c-red m-b-15" id="tt_total">{{ $booking->total or '0.00' }}</p>
      </div>

       <br/>
      <div class="alert  alert-info alert-dismissible" role="alert">
      <h4>Customer Information</h4>
      </div>

      <div class="form-group fg-line">
        <label for="name">Customer Name</label>
        <input type="text"  name="c_name" value="{{ $customer[0]->c_name or '' }}" class="form-control " id="c_name" placeholder="Customer Name" required>
      </div>

       <div class="form-group fg-line">
        <label for="name">Phone Number</label>
        <input type="number"  name="c_number" value="{{ $customer[0]->c_number or '' }}" class="form-control " id="c_name" placeholder="Customer Phone no" required>
      </div>


       <div class="form-group">
            <div class="fg-line">
                <textarea class="form-control" rows="5" name="c_address" placeholder="Address/Notes.." required>{{ $customer[0]->c_address or '' }}</textarea>
            </div>
        </div>
 <br/>
    <div class="alert  alert-info alert-dismissible" role="alert">
      <h4>Pricing Information</h4>
      </div>

      @if (empty($booking->id)) 
       <div class="form-group fg-line">
        <label for="name">Discount</label>
        <input type="number" step=".01"  name="discount" value="{{ $booking->discount or '0.00' }}" class="form-control " id="discount" placeholder="Discount">
      </div>
      @else
        <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Status</p>
          <p class="f-500 c-red m-b-15" id="pm_amount">{{ $bookingStatus[$booking->active] }}</p>
        </div>

        <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Applied Discount</p>
          <p class="f-500 c-red m-b-15" id="pm_amount">{{ $booking->discount or '0.00' }}</p>
        </div>
      @endif


      <div class="form-group fg-line">
        <label for="name">Total</label>
        <p class="f-500 c-red m-b-15" id="total_with_disc">{{ $booking->total or '0.00' }}</p>
        <input type="hidden"  name="total" value="{{ $booking->total or '0.00' }}" class="form-control " id="total">
      </div>

       <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Payment</p>
          <select name="payment_type" id="payment_type" class="form-control pad" required>
             <option value="">--Select--</option>
              <option value="1">Advance</option>
              <option value="2">Full Payment</option>
        </select>
      </div>


    @if (!empty($booking->id)) 
    <div class="alert  alert-info alert-dismissible" role="alert">
      <h4>Last payment</h4>
      </div>
       <div class="form-group fg-line">
        <label for="name">Paid</label>
        <p class="f-500 c-red m-b-15" id="paid">
         @foreach($bookingPayment as $value)
        @php
        $paid += $value->amount
        @endphp
      @endforeach        
       {{$paid }}</p>
      </div>
      <div class="form-group fg-line" >
        <p class="f-500 c-black m-b-15">Remaing</p>
        <p class="f-500 c-red m-b-15" id="balance">{{ $booking->total  - $paid }}</p>
      </div>
    @endif


      <div class="form-group fg-line" id="advance_div" style="display: none">
        <label for="name">Advance</label>
        <input type="number"  step=".01" name="advance"  value="{{ (!empty($booking) ? ($booking->total  - $paid) : '')  }}" class="form-control " id="advance" placeholder="Advance">
      </div>

    <div class="alert alert-warning warning" role="alert" style="display: none">There few overlapping booking exist with the selected Halls</div>

      <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>

      {!! Form::close() !!}

@if (!empty($booking->id)) 
<br/><br/>
<br/>

<div class="alert  alert-info alert-dismissible" role="alert">
<h4>Payment History</h4>
</div>
<table style="width:100%">
  <tr>
    <th>Sno</th>
    <th>Paid Type</th> 
    <th>Paid Amount</th> 
    <th>Date</th>
    <th>Action</th>
  </tr>

  @foreach($bookingPayment as $value)
    <tr>
      <td>{{$sno++}}</td>
      <td>{{($value['payment_type'] == '1' ? 'Advance' : 'Full Payment')}}</td> 
      <td>{{$value['amount']}}</td>
      <td>{{$value['paid_date']}}</td>
      <td><a href='/booking/{{$booking->id}}/?pid={{$value["bpid"]}}&ptype={{$value["payment_type"]}}'>Print</a></td>
    </tr>
  @endforeach

</table>

@if (!empty($booking->active) && $booking->active == 1) 
{!! Form::open(array('action' => array('BookingController@deactiveBooking', !empty($booking->id) ? $booking->id : '' ),
 'class' => 'form', 'method' => 'PATCH')) !!}
 <input type="hidden" name="active" value="3" />
  <input type="submit" value="Cancel the Booking">
{!! Form::close() !!}
@endif

    </div>
</div>


@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">


@if (!empty($booking->id)) 
  getPriceMapping({{ $booking->day_type }}, {{ $booking->pm_id }});

  //getAddonPrice({{ $booking->day_type }}) 
@endif

function checkDuplicate(dayType, pm_id, date) {

  if ((dayType != undefined && dayType !== '') && (pm_id != undefined && pm_id !== '') && (date != undefined && date !== '')) {
    $.getJSON("/booking/check-duplicate/"+ dayType + '/' + pm_id + '/' + date, function(data) {
        var i =0;

        if (data[0] !== undefined) {
          $(".warning").show();
        }else {
          $(".warning").hide();
           
        }

    })
  }

}

function getPriceMapping(dayType, pm_id) {

  if (pm_id == undefined || pm_id == '') {
    pm_id = null
  } 

  $.getJSON("/price-mapping/by-day-type/"+ dayType, function(data) {
     $("#pm_id").find('option').remove()
     $("#pm_id").append('<option value="">-- Select Hall --</option>');
     var i =0;
      $.each(data, function(){
          $("#pm_id").append('<option value="'+ data[i].id +'" data-price="'+ data[i].price +'" ' + (data[i].id == pm_id ? 'selected' : '') + '>'+ this.name +'</option>')
          i++;
      })
  })
}

function getAddonPrice(day_type) {

  if (day_type == undefined || day_type == '') {
    dayType = this.value
  } else {
    dayType = day_type
  }

   $.getJSON("/addon/by-day-type/"+ dayType, function(adata) {
    var i =0;
    $("#addon").html('');
      $.each(adata, function(){
        $("#addon").append("<label class='checkbox-inline'><input type='checkbox' class='addon' value='"+ adata[i].id +"' name='addon[]' data-addon-price='"+ adata[i].price +"'>"+ adata[i].add_name +"</label>");
        i++;
      })
  })  
}

$('#day_type').on('change', function() {

  getPriceMapping(this.value)

  getAddonPrice(this.value) 

  checkDuplicate($('#day_type').val(), $('#pm_id').val(), $('#b_date').val()) 

})

$('#b_date').on('input click', function() {
  checkDuplicate($('#day_type').val(), $('#pm_id').val(), $('#b_date').val()) 
})

$('#pm_id').on('change', function() {

    var selected = $(this).find('option:selected');
    var price = selected.data('price'); 
    $("#pm_amount").html(price)
    $("#h_total").val(price)
    total()
    checkDuplicate($('#day_type').val(), $('#pm_id').val(), $('#b_date').val()) 
})

$(document).on("change", "input[name='addon[]']", function () {
    var addon_price = parseFloat($(this).data('addon-price'));
    var get_addon_price = parseFloat($("#addon_amount").html());

    if (this.checked) {
      $("#addon_amount").html((get_addon_price + addon_price).toFixed(2))
      $("#addon_amount").val((get_addon_price + addon_price).toFixed(2))
    } else {
      $("#addon_amount").html((get_addon_price - addon_price).toFixed(2))
      $("#addon_amount").val((get_addon_price - addon_price).toFixed(2))
    }
    total()
});

$('#payment_type').on('change', function() {
  if ($(this).val() == 1) {
    $("#advance_div").show();
  }else {
     $("#advance_div").hide()
  }
})


$('#discount').on('input', function() {
    var discount  = parseFloat($(this).val())
    var tt_total =  parseFloat($("#tt_total").html())
    $("#total").val(tt_total - ((tt_total * discount) / 100));

});

function total() {
  var hallAmount = parseFloat($("#pm_amount").html());
  var addonAmount = parseFloat($("#addon_amount").html());
  $("#add_total").val(addonAmount);
  var total = hallAmount + addonAmount;
   $("#tt_total").html(total);
   $("#total_with_disc").html(total)
   $("#total").val(total)
}

$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('mousewheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('mousewheel.disableScroll')
})

</script>
@endsection