<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcv;

class PCFRController extends Controller
{


    public function index() {

        return view('pages.pcfr.index');

    }

    public function showPCV($id) {

        $pcv = Pcv::find($id);

        return view('pages.pcfr.pcv', compact('pcv'));

    }

}
