<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class BookingType extends Model
{
    //
    protected $table = "booking_type";
    public $fillable = ['name'];
}
