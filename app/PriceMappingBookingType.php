<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceMappingBookingType extends Model
{
    //
    protected $table = "price_mapping_btype";
    public $fillable = ['id','btype_id'];
    public $timestamps = false;

    
}
