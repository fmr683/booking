<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    //
    protected $table = "booking_payment";
    public $fillable = ['id','payment_type', 'paid_date', 'amount'];
    public $timestamps = false;
}
