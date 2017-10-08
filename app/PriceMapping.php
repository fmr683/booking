<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PriceMapping extends Model
{
    //
    protected $table = "price_mapping";
    public $fillable = ['day_type','price'];


    /**
     * Get the bookingType that owns the comment.
     */
    public function bookingType()
    {
       
      //  return $this->hasOne('App\BookingType', 'id', 'booking_type_id');
    }

    public static function getAllPriceMapping() {

      return DB::table("price_mapping")
                     ->select('price_mapping.id','price_mapping.price','price_mapping.day_type', DB::raw("GROUP_CONCAT(booking_type.name ORDER BY booking_type.name ASC SEPARATOR ', ') AS name"))
                     ->join('price_mapping_btype', 'price_mapping.id', '=', 'price_mapping_btype.id')
                     ->join('booking_type', 'price_mapping_btype.btype_id', '=', 'booking_type.id')
                     ->groupBy('price_mapping.id')
                     ->groupBy('price_mapping.price')
                     ->groupBy('price_mapping.day_type')
                     ->get();
    }

    public static function getAllPriceMappingbyDay($id) {

      return DB::table("price_mapping")
                     ->select('price_mapping.id', 'price_mapping.price',  DB::raw("GROUP_CONCAT(booking_type.name ORDER BY booking_type.name ASC SEPARATOR ', ') AS name"))
                     ->join('price_mapping_btype', 'price_mapping.id', '=', 'price_mapping_btype.id')
                     ->join('booking_type', 'price_mapping_btype.btype_id', '=', 'booking_type.id')
                     ->where('price_mapping.day_type','=',$id)
                     ->groupBy('price_mapping.id')
                     ->groupBy('price_mapping.price')
                     ->groupBy('price_mapping.day_type')
                     ->get();
    }

    /* SELECT pm.id, day_type, price, GROUP_CONCAT(name ORDER BY name ASC SEPARATOR ', ') AS name
     FROM `price_mapping` pm JOIN price_mapping_btype pmb ON pm.id = pmb.id JOIN booking_type bt 
     ON pmb.btype_id = bt.id GROUP BY pm.id */

}
