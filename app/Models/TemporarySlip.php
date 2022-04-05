<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class TemporarySlip extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;

	protected $guarded = [];

	protected $dates = ['date_created', 'received_date'];


	protected $auditExclude  = [];


	public static function generateTSNumber() {

		$latest_ts = TemporarySlip::whereHas('user', function($query){
				$query->where('assign_to', auth()->user()->assign_to);
			})
			->latest()
			->get();

		if(count($latest_ts))
			return 'TS-'. sprintf('%04d', count($latest_ts) + 1);

		return 'TS-'. sprintf('%04d', 1);

	}

	public function user() {

		return $this->belongsTo(User::class);

	}

	public function pcv() {
		return $this->hasMany(Pcv::class, 'slip_no', 'ts_no');
	}

}