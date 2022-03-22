<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected $casts = [
        'attachment'   => 'array'
    ];


    public static function getVendors() {

        return \DB::table('vendors')->where('status', 1)->get();

    }


    public function attachments() {

        return $this->hasMany(Attachment::class, 'from_ref')
            ->where(function($query) {
                return $query->where('from', 'vendor');
            });

    }


    public function branch() {

        return $this->belongsTo(Branch::class);

    }

}
