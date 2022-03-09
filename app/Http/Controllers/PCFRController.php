<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PCFRController extends Controller
{


    public function index() {

        return view('pages.pcfr.index');

    }

    public function create() {

        return view('pages.pcfr.create');

    }

}
