<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Trucker;

class TruckersController extends Controller
{

    public function search(Request $request) {

        $truckers = Trucker::where('slps_no', $request->search)->get();

        return response()->json($truckers);

    }

}
