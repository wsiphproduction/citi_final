<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempPosTransaction;

class PosTransactionController extends Controller
{



    public function search(Request $request) {

        return response()->json(TempPosTransaction::where('pos_no', $request->search)->get());

    }


}
