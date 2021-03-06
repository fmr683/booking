<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Booking;
use App\Customer;
use App\BookingAddon;
use App\BookingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 

        $rarray = array();
        if (empty($request["sdate"])) { $rarray['sdate'] = date('Y-m-d'); } 
        else { $rarray['sdate'] = $request["sdate"];}
        
        if (empty($request["edate"])) { $rarray['edate'] = date('Y-m-d'); } 
        else { $rarray['edate'] = $request["edate"];}
        
        $bookingStatus = array_flip(bookingStatus());
        if (empty($request["bstatus"]) && !isset($request["bstatus"]) ) $rarray['bstatus'] = array($bookingStatus["Pending"],$bookingStatus["Completed"]); 
        elseif (empty($request["bstatus"])) $rarray['bstatus'] =  $bookingStatus;
        else $rarray['bstatus'] = array($request["bstatus"]);

        $dayTypes = array_flip(dayTypes());
        if (empty($request["dtype"]) && !isset($request["dtype"])) $rarray['dtype'] = $dayTypes; 
        elseif (empty($request["dtype"])) $rarray['dtype'] = $dayTypes;
        else $rarray['dtype'] = array($request["dtype"]);
        


        $bookings = Booking::getAllBookings($rarray);
        return view('booking.index', compact('bookings','rarray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $action = array('action' => 'booking.store', 'method'=> 'POST');
        return view('booking.addEdit',compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $duplicate = "Hall Unavailable, Please select a Different Hall Type or Select New Date";

        if (!empty($this->checkDuplicateBookings($request, false)[0])) { // overlapping booking 
                return redirect('booking/create/')->with('error', $duplicate);
        }

     $full_paid = false;
      DB::beginTransaction();
       try {
           
            $customer = Customer::create($request->all());
            $request['c_id'] = $customer->id;

            if ($request['payment_type'] == 1) {
                $request['amount'] = $request['advance'];
                 $request['active'] = 1; // Pending
            } else if ($request['payment_type'] == 2){
                $request['amount'] = $request['total'];
                $request['active'] = 2; // Completed
                $full_paid = true;
            }

            if (!empty($request['discount']) && $request['discount'] > 0) {
                if ($request['discount_type'] == 1) { // % percentage
                    $request["total"] = $request["total"]  - (($request['total'] * $request['discount']) / 100);
                } else if($request['discount_type'] == 2) { // Rs discount
                    $request["total"] = $request["total"] - $request['discount'];
                }
                
                if ($full_paid) {
                    $request['amount'] = $request["total"];
                }
            }

            $booking = Booking::create($request->all());
            $request['id'] = $booking->id;
   
            for($i=0; $i < count($request->addon); $i++){ 

                BookingAddon::create(array(
                'id'=> $booking->id,
                'addon_id'=>$request->addon[$i]));
            }

            if (!empty($request["payment_type"])) {
                $request['paid_date'] = date('Y-m-d');
                BookingPayment::create($request->all());
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            dd($e);
            return redirect('booking/create/')->with('error', $duplicate);
        }


        return redirect('booking/'. $booking->id .'/edit/')->with('success', 'Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Booking $booking)
    {
        //

        $addons = Addon::where('day_type', $booking->day_type)->get();
        $customer = Customer::where('id', $booking->c_id)->get();
        $bookingAddons = BookingAddon::where('id', $booking->id)->get();
        $bookingPayment = BookingPayment::where('id', $booking->id)->where('bpid',$request->pid)->get();
        $totBookingPayment = BookingPayment::where('id', $booking->id)->get();
        $action = array('action' => 'booking.update', 'method'=> 'PATCH');
        $booking->name = Booking::getBookingName(array('id'=>$booking->id))[0]->name; // set the hall name
        $payment_type = $request->ptype;

        $print_addons = '';
        foreach($addons as $key => $value) {
            foreach($bookingAddons as $bakey => $bavalue) {
                if($bavalue->addon_id == $value->id) {
                    $print_addons .= $value->add_name . ' ' ;
                }
            }
        }

        if ($payment_type ==2) { // full payment
           $data_arr = array('title' => 'FINAL INVOICE','payment_type'=>$payment_type);
        } else {
           $data_arr = array('title' => 'RECEIPT','payment_type'=>$payment_type);
        }

         return view('booking.receipt',compact('action','booking',
            'customer','bookingPayment','print_addons','totBookingPayment','data_arr'));
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
        $addons = Addon::where('day_type', $booking->day_type)->get();
        $customer = Customer::where('id', $booking->c_id)->get();
        $bookingAddons = BookingAddon::where('id', $booking->id)->get();
        $bookingPayment = BookingPayment::where('id', $booking->id)->get();
        $action = array('action' => 'booking.update', 'method'=> 'PATCH');
        return view('booking.addEdit',compact('action','booking','customer','bookingAddons','bookingPayment','addons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
        DB::beginTransaction();
        try {


            $request['amount'] = $request['advance'];

            if ($request['payment_type'] == 1) {
               $request['active'] = 1; // Pending
            } else if ($request['payment_type'] == 2){
              $request['active'] = 2; // Completed
            }

            Booking::find($booking->id)->update($request->all());
            $request['id'] = $booking->id;

            Customer::where('id', $booking->c_id)
            ->update(array('c_name' => $request['c_name'],
                            'c_number' => $request['c_number'],
                            'c_address' => $request['c_address'] ));
            BookingAddon::where('id', $booking->id)->delete();

            for($i=0; $i < count($request->addon); $i++){ 

                BookingAddon::create(array(
                'id'=> $booking->id,
                'addon_id'=>$request->addon[$i]));
            }

            if (!empty($request["payment_type"])) {
                $request['paid_date'] = date('Y-m-d');
                BookingPayment::create($request->all());
            }
          DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            dd($e);
            return redirect('booking/'. $booking->id .'/edit/');
        }

        return redirect('booking/'. $booking->id .'/edit/')->with('success', 'Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function deactiveBooking(Request $request) {
        Booking::find($request->id)->update($request->all());
        return redirect('booking')->with('success', 'Success!');
    }

    public function checkDuplicateBookings(Request $request, $ajax=true) {

        $rarray = array('day_type'=>$request->day_type, 'pm_id'=>$request->pm_id
        , 'b_date'=>$request->b_date, 'bid'=>$request->bid);

      //  dd($rarray);
        if ($ajax)
            echo Booking::checkPossibleDuplicateItem($rarray);
        else 
            return Booking::checkPossibleDuplicateItem($rarray);
        exit;
    }

      
}
