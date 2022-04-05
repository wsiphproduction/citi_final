<?php

namespace App\Helpers;

class Helper {

	public static function basic_actions() {
		return ['view', 'add', 'edit', 'delete'];
	}

	public static function account_types() {
		return ['expense', 'receivable'];
	}


	public static function chargeTo() {

		$branch = auth()->user()->branch;

		$charge_to = \DB::table('temp_charge_to')
			->where('ORGANIZATION_NAME', $branch->company_name)
			->get();

		return $charge_to;

	}

}