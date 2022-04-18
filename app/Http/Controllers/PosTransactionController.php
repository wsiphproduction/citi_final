<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempPosTransaction;

class PosTransactionController extends Controller
{



    public function search(Request $request) {

        $user = auth()->user();

        $transactions = TempPosTransaction::where('universal_trx_id', $request->search)
            ->where('store_id', $user->branch->store_id)
            ->get();

        if(count($transactions)) {

            foreach( $transactions as $transaction ) {

                $total_qty_installed = 0;

                $account_transactions = \App\Models\Pcv::where('account_name', 'Installation')
                    ->whereHas('user', function($query) {
                        $query->where('assign_to', auth()->user()->assign_to);
                    })
                    ->with('account_transaction')
                    ->get();

                if(count($account_transactions)) {

                    foreach( $account_transactions as $transac ) {

                        foreach( $transac->account_transaction->details as $transaction_details ) {

                            foreach( $transaction_details['items'] as $key => $item ) {

                                if( $transaction->barcode == $transaction_details['items'][$key]['barcode']) {

                                    $total_qty_installed = $total_qty_installed + $transaction_details['items'][$key]['qty_for_installation'];

                                }

                            }

                        }

                    }

                }

                $transaction->qty_with_pcv = $total_qty_installed;

            }

        }

        return response()->json($transactions);

    }


    public function show($id) {

        $transactions = TempPosTransaction::where('universal_trx_id', $id)
            ->get();

        return view('pages.pcv.pos-trans', compact('transactions'));

    }


}
