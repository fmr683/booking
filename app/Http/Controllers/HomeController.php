<?php

namespace App\Http\Controllers;
use App\Booking;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $rarray = array();
        if (empty($request["sdate"])) { $rarray['sdate'] = null; } 
        else { $rarray['sdate'] = $request["sdate"];}
        
        if (empty($request["edate"])) { $rarray['edate'] = null; } 
        else { $rarray['edate'] = $request["edate"];}
        

        $bookings = Booking::getRecentPendingOrders($rarray);
        return view('home',compact('bookings','rarray'));
    }
}
