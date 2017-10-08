<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    //
    protected $table = "addon";
    public $fillable = ['add_name','day_type','price'];
}
