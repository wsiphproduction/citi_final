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
        
        asort($accounts);
        
        return $accounts;

    }

    public static function getUnsortedAccounts() {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);
        
        return $accounts;

    }

    public static function getAccountsFinal() {

        $jsonString = file_get_contents(base_path('public/data/accounts_final.json'));
        $accounts = json_decode($jsonString, true);

        asort($accounts);
        
        return $accounts;

    }

    public function account_transactions(){
        return $this->hasMany(AccountTransactions::class, 'account_name');
    }

}
