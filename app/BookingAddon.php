<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingAddon extends Model
{
    //
    protected $table = "booking_addon";
    public $fillable = ['id','addon_id'];
    public $timestamps = false;
}
