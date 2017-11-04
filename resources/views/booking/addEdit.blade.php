
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

 <div class="row">
         <button class="btn bgm-bluegray waves-effect float-right" onclick="window.location.href='/booking/'">Back</button>
        </div>
        <br/>

      {!! Form::open(array('route' => array($action["action"], (!empty($booking->id) ? $booking->id : '' )),
      'class' => 'form', 'method' => $action["method"])) !!}

          <div class="alert alert-warning warning" role="alert" style="display: none">Hall Unavailable, Please select a Different Hall Type or Select New Date.</div>

<div class="alert  alert-info alert-dismissible" role="alert">
   <h4>Booking Information</h4>
</div>

      <div class="form-group fg-line">
        <label for="name">Date</label>
        <input type="text" {{(!empty($booking->id) ? 'disabled' : '' )}} name="b_date" value="{{ $booking->b_date or '' }}" class="form-control date-picker" id="b_date" placeholder="Booking Date" required>
      </div>

      <div class="form-group fg-line" >
          <select class="form-control pad"name="day_type" id="day_type" required {{(!empty($booking->id) ? 'disabled' : '' )}}>
            <option value="">-- Select Day Type --</option>
           @foreach(dayTypes() as $key => $dayType)
            <option value="{{$key}}" {{ (!empty($booking) && $booking->day_type == $key ? 'selected' : '')  }}>{{$dayType}}</option>
          @endforeach
        </select>
      </div>


       <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Hall</p>
          <select name="pm_id" id="pm_id" class="form-control pad" required {{(!empty($booking->id) ? 'disabled' : '' )}}>
           <option value="">-- Select Hall --</option>
        </select>
      </div>



    <div class="form-group fg-line" >
      <p class="f-500 c-black m-b-15">Extras</p>
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
          <p class="f-500 c-red m-b-15" id="pm_amount">
          <?=number_format(!empty($booking->h_total) ? $booking->h_total: 0,2)?>
          </p>
          <input type="hidden" name="h_total"  step=".01" id='h_total'  value="{{ $booking->h_total or '0.00' }}">
      </div>

      <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Extras Amount</p>
          <p class="f-500 c-red m-b-15" id="addon_amount"><?=number_format(!empty($booking->add_total) ? $booking->add_total: 0,2)?></p>
          <input type="hidden" name="add_total"  step=".01" id='add_total'  value="{{ $booking->add_total or '0.00' }}">
      </div>


       <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Total Booking Price</p>
          <p class="f-500 c-red m-b-15" id="tt_total">
          @if (!empty($booking->id))
          {{ number_format(($booking->h_total + $booking->add_total),2) }}
          @else 
          {{ '0.00'}}
          @endif
          </p>
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
       <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Discount</p>
          <select name="discount_type" id="discount_type" class="form-control pad" >
             <option value="">--Select--</option>
              <option value="1">%</option>
              <option value="2">Rs</option>
        </select>
        <br/>
         <input type="number" step=".01"  name="discount" min="0" value="{{ $booking->discount or '0.00' }}" class="form-control " id="discount" placeholder="Discount">
      </div>

      @else
        <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Status</p>
          <p class="f-500 c-red m-b-15" id="pm_amount">{{ $bookingStatus[$booking->active] }}</p>
        </div>

        <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Applied Discount</p>
          <p class="f-500 c-red m-b-15" id="pm_amount"><?=number_format(!empty($booking->discount) ? $booking->discount: 0,2)?></p>
        </div>
      @endif


      <div class="form-group fg-line">
        <label for="name">Final Price</label>
        <p class="f-500 c-red m-b-15" id="total_with_disc"><?=number_format(!empty($booking->total) ? $booking->total: 0,2)?></p>
        <input type="hidden"  name="total" value="{{ $booking->total or '0.00' }}" class="form-control " id="total">
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
       {{number_format($paid,2) }}</p>
      </div>
      <div class="form-group fg-line" >
        <p class="f-500 c-black m-b-15">Outstanding</p>
        <p class="f-500 c-red m-b-15" id="balance">{{ number_format($booking->total  - $paid,2) }}</p>
      </div>
    @endif
   

 <div class="form-group fg-line" >
          <p class="f-500 c-black m-b-15">Payment</p>
          <select name="payment_type" id="payment_type" class="form-control pad" {{(empty($booking->id) ? 'required' : '' )}} >
             <option value="">--Select--</option>
              <option value="1">Advance</option>
              <option value="2">Full Payment</option>
        </select>
      </div>

      <div class="form-group fg-line" id="advance_div" style="display: none">
        <input type="number"  step=".01" min="0" name="advance"  value="{{ (!empty($booking) ? ($booking->total  - $paid) : '')  }}" class="form-control " id="advance" placeholder="Advance">
      </div>

    <div class="alert alert-warning warning" role="alert" style="display: none">Hall Unavailable, Please select a Different Hall Type or Select New Date.</div>

     @if (empty($booking->id) || (!empty($booking->active) && $booking->active == 1))
      <button type="submit" class="submit btn btn-primary btn-sm m-t-10">Submit</button>
    @else
     <div class="alert alert-warning" role="alert">Sorry you cannot edit the booking because it's either Completed/Canceled </div>
    @endif

      {!! Form::close() !!}

@if (!empty($booking->id)) 
<br/><br/>
<br/>

  <div class="row">
    <div class="col-sm-10 col-xs-6"></div>
    <div class="col-sm-2 col-xs-6"> 
@if (!empty($booking->active) && ($booking->active == 1 || $booking->active == 2)) 
{!! Form::open(array('action' => array('BookingController@deactiveBooking', !empty($booking->id) ? $booking->id : '' ),
 'class' => 'form', 'method' => 'PATCH')) !!}
 <input type="hidden" name="active" value="3" />
  <button type="submit" class=" btn btn-danger btn-sm m-t-10">Cancel the Booking</button>
{!! Form::close() !!}
@endif
</div>
  </div>
  
<br/>
<br/>

<div class="alert  alert-info alert-dismissible" role="alert">
<h4>Payment History</h4>
</div>
  <div class="table-responsive">
    <table id="data-table-basic" class="table table-striped">
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
          <td>{{number_format($value['amount'],2)}}</td>
          <td>{{$value['paid_date']}}</td>
          <td><a target="_blank" href='/booking/{{$booking->id}}/?pid={{$value["bpid"]}}&ptype={{$value["payment_type"]}}'>Print</a></td>
        </tr>
      @endforeach

    </table>
</div>


    </div>
</div>


@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">


@if (!empty($booking->id)) 
  getPriceMapping({{ $booking->day_type }}, {{ $booking->pm_id }});
 checkDuplicate({{ $booking->day_type or '' }}, {{ $booking->pm_id or '' }}, "{{ $booking->b_date or '' }}",  {{ $booking->id or '' }}) 
  //getAddonPrice({{ $booking->day_type }}) 
@endif

function checkDuplicate(dayType, pm_id, date, bid) {

  if (bid == undefined || bid == '') bid = 0;

  if ((dayType != undefined && dayType !== '') && (pm_id != undefined && pm_id !== '') && (date != undefined && date !== '')) {
    $.getJSON("/booking/check-duplicate/"+ dayType + '/' + pm_id + '/' + date + '/' + bid, function(data) {
        var i =0;
        if (data[0] !== undefined) {
        //  $(".submit").hide();
          $(".warning").show();
        }else {
         // $(".submit").show();
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
forcAllValuetoEmpty();
  getPriceMapping(this.value)

  getAddonPrice(this.value) 

  checkDuplicate($('#day_type').val(), $('#pm_id').val(), $('#b_date').val(),  {{ $booking->id or '' }}) 

  
})


function forcAllValuetoEmpty() {
   $("#total_with_disc").html('0.00');
    $("#h_total").val(0.00);
    $("#pm_amount").html('0.00');
    $("#addon_amount").html('0.00');
    $("#total").val(0.00)
    $("#add_total").val(0.00);
    $("#tt_total").html('0.00');
}

@if (empty($booking->id)) 
$("input").on( 'input', function() {
   checkDuplicate($('#day_type').val(), $('#pm_id').val(), $('#b_date').val()) 
});
@endif


$('#b_date').on('input click', function() {
  checkDuplicate($('#day_type').val(), $('#pm_id').val(), $('#b_date').val()) 
})

$('#pm_id').on('change', function() {
    $("#total_with_disc").html('');
    var selected = $(this).find('option:selected');
    var price = selected.data('price'); 
    $("#pm_amount").html(numberWithCommas(price))
    $("#h_total").val(price)
    total()
})

$(document).on("change", "input[name='addon[]']", function () {
    var addon_price = parseFloat($(this).data('addon-price'));
    var get_addon_price = parseFloat($("#addon_amount").html().replace(/,/g, ""));


    if (this.checked) {
      var x = get_addon_price + addon_price;
      $("#addon_amount").html(numberWithCommas(x.toFixed(2)))
     // $("#addon_amount").val((get_addon_price + addon_price).toFixed(2))
     total(addon_price)
    } else {
      var x = get_addon_price - addon_price;
      $("#addon_amount").html(numberWithCommas(x.toFixed(2)))
     // $("#addon_amount").val((get_addon_price - addon_price).toFixed(2))
     total(-addon_price)
    }
});



$('#payment_type').on('change', function() {
  if ($(this).val() == 1) {
    $("#advance_div").show();
  }else {
     $("#advance_div").hide()
  }
})



function total(t_addon) {

  if (t_addon == undefined) t_addon = null

  var hallAmount = parseFloat($("#pm_amount").html().replace(/,/g, ""));
  var addonAmount = parseFloat($("#addon_amount").html().replace(/,/g, ""));
  $("#add_total").val(addonAmount);
  var total = hallAmount + addonAmount;
  total = numberWithCommas(total.toFixed(2));

   $("#tt_total").html(total); // Total Booking info
   var paid = parseFloat($("#paid").html().replace(/,/g, ""));
   if (paid == undefined || paid == '') {
      paid = 0.00;
   }

   var tot_with_dic = parseFloat($("#total_with_disc").html().replace(/,/g, ""));
   if (tot_with_dic > 0) {
      var n = tot_with_dic + t_addon;
      var y = numberWithCommas(n.toFixed(2));
      $("#total_with_disc").html(y)
      //var z = tot_with_dic + t_addon;
      $("#total").val(tot_with_dic + t_addon)
       $("#advance").val((tot_with_dic + t_addon) - paid);
   } else {
    $("#total_with_disc").html(total)
    $("#total").val(total.replace(/,/g, ""))
     $("#advance").val(total.replace(/,/g, "") - paid)
   }

    checkDuplicate($('#day_type').val(), $('#pm_id').val(), $('#b_date').val(),  {{ $booking->id or '' }}) 
  
}

$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('mousewheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('mousewheel.disableScroll')
})

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

</script>
@endsection