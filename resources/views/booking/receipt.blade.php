@php 
    $dayTypes = dayTypes();
    $bookingStatus = bookingStatus();
    $paid = 0.00;
    $addons = '';
@endphp

 @foreach($totBookingPayment as $value)
  @php
  $last_paid = $value->amount;
  $paid += $value->amount;
  @endphp
@endforeach  

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>

<table style="width:100%">
  <tr>
    <td><h1>DATA BANQUET HALL</h1>
        No-77, Old Galle Road, <br/> Sarikkamulla,<br/> Panadura<br/> Hotline - 0777237470
    </td>
    <td ><img src="/img/logo.jpg"></td>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h2>{{$data_arr["title"]}}</h2></td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="border: 2px solid black">

        <table style="width:100%">
          <tr>
            <td><b>Customer Name:</b> {{ $customer[0]->c_name or '' }}</td>
            <td><b>Date:</b> {{ $bookingPayment[0]->paid_date or '' }}</td>
          </tr>
          
          <tr>
            <td><b>Address:</b> {{ $customer[0]->c_address or '' }}</td>
            <td><b>Booking ID No:</b> #{{ $booking->id }}</td>
          </tr>

          <tr>
            <td><b>Tel:</b> {{ $customer[0]->c_number }}</td>
            <td></td>
          </tr>
        </table>
    
    </td>
  </tr>

  <tr>
    <td style="width: 70%; border: 2px solid black">

      <table>
        <tr>
          <td><b>Date:</b> {{ $booking->b_date }}</td>
        </tr>
        <tr>
          <td><b>Time Slot:</b> {{ $dayTypes[$booking->day_type] }}</td>
        </tr>
        <tr>
          <td><b>Hall Type:</b> {{ $booking->name }}</td>
        </tr>
        <tr>
          <td><b>Extra Items:</b>
          
            {{ $print_addons }}

          </td>
        </tr>
      </table>
    
    </td>
    <td>

      <table>
        <tr>
          <td><b>Grand Total:</b></td>
          <td>{{ number_format($booking->total, 2) }}</td>
        </tr>

        
        @if ($data_arr["payment_type"] == 2)
         <tr>
          <td><b>Discount Amount:</b></td>
          <td>{{ number_format($booking->discount, 2) }}</td>
        </tr>
        <tr>
          <td><b>Paid Amount:</b></td>
          <td>{{ number_format($last_paid , 2)}}</td>
        </tr>

         <tr>
          <td><b>Total Paid Amount:</b></td>
          <td>{{ number_format($paid , 2)}}</td>
        </tr>
        @else
         <tr>
          <td><b>Advance Payment:</b></td>
          <td><?= !empty($bookingPayment[0]->amount) ? number_format($bookingPayment[0]->amount, 2) : 0.00 ?></td>
        </tr>
         <tr>
          <td><b>Balance Payment:</b></td>
          <td>
            {{number_format($booking->total - $paid, 2) }}
          </td>
        </tr>

        @endif
      </table>
    
    </td>
  </tr>
  @if ($data_arr["payment_type"] == 1)
   <tr>
    <td colspan="2" align="center"><br/>Please note final payment has to be made 10 days before the wedding date</td>
  </tr>
  @endif
</table>

<script>
window.print();
</script>