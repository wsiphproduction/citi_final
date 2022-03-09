<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcv extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'pcv';


    public static function generatePCVNumber() {

        $latest_pcv = \DB::table('pcv')->latest()->first();
        if($latest_pcv)
            return 'PCV-'. date('ym') . '-'. ( $latest_pcv->id + 1 );

        return 'PCV-'.date('ym') . '-1';

    }


    public function account_transactions() {

        return $this->hasMany(AccountTransaction::class);

    }


    public function pcfr() {

        return $this->belongsTo(Pcfr::class);

    }


    public function attachments() {

        return $this->hasMany(Attachment::class, 'from_ref')
            ->where(function($query) {
                return $query->where('from', 'pcv');
            });

    }


    public function user() {

        return $this->belongsTo(User::class);

    }


}
