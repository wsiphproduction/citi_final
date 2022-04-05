<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcfr extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'pcfr';


    public static function generatePCFRNumber() {

        $pcfr = Pcfr::whereHas('user', function($query){
                $query->where('assign_to', auth()->user()->assign_to);
            })
            ->latest()
            ->get();

        if(count($pcfr))
            return 'PCF-'. auth()->user()->assign_to .'-'.date('Ymd') . '-'. ( count($pcfr) + 1 );

        return 'PCF-'. auth()->user()->assign_to .'-' . date('Ymd') . '-1';

    }


    public static function generatePCFRBatchNumber() {

        $latest_pcv = \DB::table('pcfr')->latest()->first();
        if($latest_pcv)
            return 'PCF-'.date('m/d/Y') . '-'. auth()->user()->assign_to . '-'. ( $latest_pcv->id + 1 );

        return 'PCF-'.date('m/d/Y') . '-'. auth()->user()->assign_to . '-1';

    }


    public function user() {

        return $this->belongsTo(User::class);

    }

    public function attachments() {

        return $this->hasMany(Attachment::class, 'from_ref')
            ->where(function($query) {
                return $query->where('from', 'pcfr');
            });

    }


    public function pcv() {

        return $this->hasMany(Pcv::class);

    }


}
