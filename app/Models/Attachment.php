<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function pcv() {

        return $this->belongsTo(Pcv::class, 'from_ref');

    }


    public function account_transactions() {

        return $this->belongsTo(AccountTransaction::class, 'from_ref');

    }


    public function pcfr() {

        return $this->belongsTo(Pcfr::class, 'from_ref');

    }


    public function vendor() {

        return $this->belongsTo(Vendor::class, 'from_ref');

    }


}
