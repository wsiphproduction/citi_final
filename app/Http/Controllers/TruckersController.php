<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Trucker;

class TruckersController extends Controller
{

    public function search(Request $request) {

        $truckers = Trucker::where('SLPSNO', $request->search)->get();

        return response()->json($truckers);

    }

}
