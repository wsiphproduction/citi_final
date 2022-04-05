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

        $pcv = Pcv::whereHas('user', function($query){
                $query->where('assign_to', auth()->user()->assign_to);
            })
            ->latest()
            ->get();

        if(count($pcv))
            return 'PCV-'. auth()->user()->assign_to . '-'. ( count($pcv) + 1 );

        return 'PCV-'.auth()->user()->assign_to . '-1';

    }

    public function ts() {
        return $this->belongsTo(TemporarySlip::class);
    }

    public function account_transaction() {

        return $this->hasOne(AccountTransaction::class);

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
