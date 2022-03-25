<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempPosTransaction;

class PosTransactionController extends Controller
{



    public function search(Request $request) {

        $user = auth()->user();

        $transaction = TempPosTransaction::where('universal_trx_id', $request->search)
            ->where('store_id', $user->branch->store_id)
            ->get();

        return response()->json($transaction);

    }


    public function show($id) {

        $transactions = TempPosTransaction::where('universal_trx_id', $id)
            ->get();

        return view('pages.pcv.pos-trans', compact('transactions'));

    }


}
