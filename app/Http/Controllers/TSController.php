<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\TemporarySlip;

class TSController extends Controller
{


    public function index() {

        $temporary_slips = TemporarySlip::whereIn('status', ['saved', 'submitted', 'confirmed'])->get();

        return view('pages.ts.index', compact('temporary_slips'));

    }

    public function create() {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);

        return view('pages.ts.create', compact('accounts'));

    }

    public function store(Request $request) {

        $this->validate($request, [
            'amount'        => 'required' ,
            'description'   => 'required' ,
            'received_by'   => 'required' ,
            
        ]);

        $request['ts_no']               = TemporarySlip::generateTSNumber();
        $request['running_balance']     = $request->amount;
        $request['user_id']             = auth()->user()->id;

        TemporarySlip::create($request->except('_token'));

        return redirect()->route('ts.index')->with('success','Temporary slip has been created!');

    }


    public function show($id) {

        $ts = TemporarySlip::find($id);

        return view('pages.ts.show', compact('ts'));

    }


    public function search(Request $request) {

        $temporary_slips = TemporarySlip::where('ts_no', 'LIKE', "%{$request->ts_no}%")->get();

        return $temporary_slips;

    }


    public function approverAction($id, Request $request) {

        $ts = TemporarySlip::find($id);

        dd($request->all());


    }


}
