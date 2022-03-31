<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Vendor extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;


    protected $guarded = [];

    protected $casts = [
        'attachment'   => 'array'
    ];

    protected $auditExclude  = [];


    public static function getVendors() {

        return \DB::table('vendors')->where('status', 1)
            ->where('branch_id', auth()->user()->assign_to)
            ->get();

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
