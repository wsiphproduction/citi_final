<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;

class ChargesController extends Controller
{


    public function index() {

        $charges = Charge::all();

        return view('pages.charges.index', compact('charges'));

    }


    public function create() {

        return view('pages.charges.create');

    }


    public function store(Request $request) {

        Charge::create($request->except('_token'));

        return redirect()->route('charges.index')->with('success', 'Charge Successfully Created!');

    }


    public function edit($id, Request $request) {



    }


    public function update($id, Request $request) {



    }


}
