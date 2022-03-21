<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected $casts = [
        'details'   => 'array'
    ];


    public function pcv() {
        return $this->belongsTo(Pcv::class, 'pcv_id');
    }

    public function attachments() {

        return $this->hasMany(Attachment::class, 'from_ref')
            ->where(function($query) {
                return $query->where('from', 'account_transaction');
            });

    }

}
