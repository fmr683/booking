<?php

namespace App\Http\Controllers;

use App\BookingType;
use Illuminate\Http\Request;

class BookingTypeController extends Controller
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

    public function index()
    {
        //
       $bookingTypes = BookingType::all();
       return view('booking_type.index', compact('bookingTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $action = array('action' => 'booking-type.store', 'method'=> 'POST');
        return view('booking_type.addEdit',compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       BookingType::create($request->all());
       return redirect('booking-type')->with('success', 'Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function show(BookingType $bookingType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingType $bookingType)
    {
        //
         $action = array('action' => 'booking-type.update', 'method'=> 'PATCH');
         return view('booking_type.addEdit', compact('bookingType','action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingType $bookingType)
    {
        //
        BookingType::find($bookingType->id)->update($request->all());
        return redirect('booking-type')->with('success', 'Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingType $bookingType)
    {
        //
        BookingType::find($bookingType->id)->delete();
        return redirect('booking-type')->with('success', 'Success!');
    }
}
