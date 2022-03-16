<?php

namespace App\Http\Controllers\Requestor;

use File;
use Illuminate\Http\Request;
use App\Models\TemporarySlip;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class TSController extends Controller
{


    public function index() {

        $temporary_slips = TemporarySlip::where('user_id', auth()->user()->id)
            ->whereIn('status', ['saved', 'approved', 'submitted'])
            ->get();

        return view('pages.ts.requestor.index', compact('temporary_slips'));

    }

    public function create() {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);

        return view('pages.ts.requestor.create', compact('accounts'));

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

        return redirect()->route('requestor.ts.index')->with('success','Temporary slip has been created!');

    }


    public function show($id) {

        $ts = TemporarySlip::find($id);        

        return view('pages.ts.requestor.show', compact('ts'));

    }


    public function edit($id) {

        $ts = TemporarySlip::find($id);
        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);

        return view('pages.ts.requestor.edit', compact('ts','accounts'));

    }


    public function update($id, Request $request) {

        $this->validate($request, [
            'amount'        => 'required' ,
            'description'   => 'required' ,
            'received_by'   => 'required' ,
            
        ]);

        $ts = TemporarySlip::find($id);

        $request['ts_no']               = TemporarySlip::generateTSNumber();
        $request['running_balance']     = $request->amount;
        $request['user_id']             = auth()->user()->id;

        $ts->update($request->except('_token','method'));

        return redirect()->route('requestor.ts.index')->with('success','Temporary slip has been updated!');

    }


    public function search(Request $request) {

        $user = auth()->user();

        $temporary_slips = TemporarySlip::where('ts_no', 'LIKE', "%{$request->ts_no}%")
            ->where('status','approved')
            ->whereHas('user', function(Builder $builder) use($user) {
                $builder->where('assign_to', $user->assign_to);
            })
            ->get();

        return $temporary_slips;

    }


    public function approverAction($id, Request $request) {

        $ts = TemporarySlip::find($id);

        dd($request->all());


    }


    public function statusUpdate($id, Request $request) {

        $ts = TemporarySlip::find($id);
        $ts->update(['status' => $request->action]);

        return back()->with(['success' => "{$ts->ts_no} was successfully submitted."]);

    }

}
