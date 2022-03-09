<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountsController extends Controller
{



    public function index() {

        return view('pages.accounts.index');

    }


    public function create() {

        return view('pages.accounts.create');

    }


    public function show($name) {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);
        $account_data = null;

        foreach( $accounts as $account ) {

            if(strtolower($account['name']) === strtolower($name)) {

                $account_data = $account;

            }

        }

        return view('components.account', compact('account_data'));

    }

}
