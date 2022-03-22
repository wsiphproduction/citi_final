<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;

class ChargesController extends Controller
{


    public function index() {

        $charges = Charge::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.charges.index', compact('charges'));

    }


    public function inactive() {

        $charges = Charge::where('status', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.charges.inactive', compact('charges'));

    }


    public function create() {

        return view('pages.charges.create');

    }


    public function show($id) {

        $charge = Charge::find($id);

        return view('pages.charges.show', compact('charge'));

    }


    public function store(Request $request) {

        Charge::create($request->except('_token'));

        return redirect()->route('charges.index')->with('success', 'Charge Successfully Created!');

    }


    public function edit($id, Request $request) {

        $charge = Charge::find($id);

        return view('pages.charges.edit', compact('charge'));

    }


    public function update($id, Request $request) {

        $charge = Charge::find($id);
        $charge->update($request->except('_token', '_method'));

        return redirect()->route('charges.index')->with('success', 'Charge Successfully Updated!');

    }


}
