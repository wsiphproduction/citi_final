<?php

namespace App\Helpers;

class Helper {

	public static function basic_actions() {
		return ['view', 'add', 'edit', 'delete'];
	}

	public static function account_types() {
		return ['expense', 'receivable'];
	}

}