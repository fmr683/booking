<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public $fillable = ['c_name','c_number','c_address'];
}
