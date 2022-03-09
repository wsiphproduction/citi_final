<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountTransaction;

class AccountTransactionController extends Controller
{



    public function store(Request $request) {

        $account_transaction = AccountTransaction::create([
            'name'      => $request->account_name ,
            'details'   => $request->details 
        ]);

        return $account_transaction;

    }


    public function show($id) {

        return AccountTransaction::find($id);

    }

}
