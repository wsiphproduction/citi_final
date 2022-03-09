<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;


    public static function getAccounts() {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);

        return $accounts;

    }

}
