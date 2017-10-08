<?php

namespace App\Http\Controllers;

use App\PriceMapping;
use App\BookingType;
use App\PriceMappingBookingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceMappingController extends Controller
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
    {//dd($priceMappings);
    
       $priceMappings = PriceMapping::getAllPriceMapping();
       return view('price_mapping.index', compact('priceMappings','action'));
       // echo $comment->bookingType->name;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $bookingTypes = BookingType::orderBy('id', 'desc')->get();
        $action = array('action' => 'price-mapping.store', 'method'=> 'POST');
        return view('price_mapping.addEdit',compact('action','bookingTypes'));
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

        $this->validate($request, [
         'btype_id'  => 'required',
        ],
        [
            'btype_id.required' => 'Please check atleast one booking type',
        ]);

      DB::beginTransaction();
       try {
           
            $priceMapping = PriceMapping::create($request->all());
            
            for($i=0; $i < count($request->btype_id); $i++){ 
            
                    PriceMappingBookingType::create(array(
                        'id'=> $priceMapping->id,
                        'btype_id'=>$request->btype_id[$i]));
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect('price-mapping/create');
        }
        

       return redirect('price-mapping')->with('success', 'Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PriceMapping  $priceMapping
     * @return \Illuminate\Http\Response
     */
    public function show(PriceMapping $priceMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PriceMapping  $priceMapping
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceMapping $priceMapping)
    {
        //
        $bookingTypes = BookingType::orderBy('id', 'desc')->get();
        $priceMappingBookingType = PriceMappingBookingType::where('id', $priceMapping->id)->get();
        $action = array('action' => 'price-mapping.update', 'method'=> 'PATCH');
        return view('price_mapping.addEdit',compact('action','bookingTypes','priceMappingBookingType','priceMapping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PriceMapping  $priceMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PriceMapping $priceMapping)
    {
        //

       
        $this->validate($request, [
            'btype_id'  => 'required',
        ],
        [
            'btype_id.required' => 'Please check atleast one booking type',
        ]);
 
       DB::beginTransaction();
       try {
           
            PriceMapping::find($priceMapping->id)->update($request->all());
            PriceMappingBookingType::where('id', $priceMapping->id)->delete();
            
            for($i=0; $i < count($request->btype_id); $i++){ 
            
                    PriceMappingBookingType::create(array(
                        'id'=> $priceMapping->id,
                        'btype_id'=>$request->btype_id[$i]));
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            dd($e);
            DB::rollBack();
            return redirect('price-mapping/'. $priceMapping->id . '/edit/');
        }


        return redirect('price-mapping')->with('success', 'Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PriceMapping  $priceMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceMapping $priceMapping)
    {
        //
        PriceMapping::find($priceMapping->id)->delete();
        PriceMappingBookingType::where('id', $priceMapping->id)->delete();
        return redirect('price-mapping')->with('success', 'Success!');
    }


    public function byDayType($id) {

       echo PriceMapping::getAllPriceMappingbyDay($id);
       exit;
    }
}
