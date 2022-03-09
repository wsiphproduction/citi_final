<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $guarded = [];


    public static function getCharges($name) {

        return \DB::table('charges')->where('name', $name)->get();

    }

}
