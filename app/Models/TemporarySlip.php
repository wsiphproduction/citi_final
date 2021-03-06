<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporarySlip extends Model
{

	protected $guarded = [];

	protected $dates = ['date_created', 'received_date'];

	public static function generateTSNumber() {

		$latest_ts = \DB::table('temporary_slips')->latest()->first();

		if($latest_ts)
			return 'TS-'. sprintf('%04d', $latest_ts->id + 1);

		return 'TS-'. sprintf('%04d', 1);

	}

	public function user() {

		return $this->belongsTo(User::class);

	}

}