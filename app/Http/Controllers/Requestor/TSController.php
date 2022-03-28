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
        $user = auth()->user();
        $temporary_slips = TemporarySlip::whereIn('status', 
                ['saved', 'approved', 'submitted','confirmed', 'disapproved','disapproved tl', 'disapproved dept head', 'disapproved dh'])
            ->whereHas('user' , function(Builder $builder) use($user) {
                if($user->getUserAssignTo() == 'ssc') {
                    $builder->where('assign_to', $user->assign_to)
                        ->where('assign_name', $user->assign_name);
                } else {
                    $builder->where('assign_to', $user->assign_to);
                }
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.ts.requestor.index', compact('temporary_slips'));

    }

    public function create() {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);

        return view('pages.ts.requestor.create', compact('accounts'));

    }

    public function store(Request $request) {

        $account = explode(" | ", $request->account);

        if(count($account) > 1) {

            $request['account_code'] = $account[0];
            $request['account_name'] = $account[1];

        }

        $this->validate($request, [
            'account_name'      => 'required' ,
            'account_code'    => 'required' ,
            'amount'            => 'required' ,
            'description'       => 'required'            
        ]);

        $request['ts_no']               = TemporarySlip::generateTSNumber();
        $request['running_balance']     = $request->amount;
        $request['user_id']             = auth()->user()->id;

        TemporarySlip::create($request->except('_token', 'account'));

        return redirect()->route('requestor.ts.index')->with('success',"Temporary slip was successfully {$request->status}");

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

        $account = explode(" | ", $request->account);

        if(count($account) > 1) {

            $request['account_code'] = $account[0];
            $request['account_name'] = $account[1];

        }

        $this->validate($request, [
            'account_name'      => 'required' ,
            'account_code'    => 'required' ,
            'amount'            => 'required' ,
            'description'       => 'required' ,
            
        ]);

        $ts = TemporarySlip::find($id);

        $request['ts_no']               = TemporarySlip::generateTSNumber();
        $request['running_balance']     = $request->amount;
        $request['user_id']             = auth()->user()->id;

        if($request->status=='submitted') {
            $request['tl_approved'] = null;
            $request['dh_approved'] = null;
        }

        $ts->update($request->except('_token','method', 'account'));

        return redirect()->route('requestor.ts.index')->with('success',"Temporary slip has been updated!");

    }


    public function update1($id, Request $request) {

        $this->validate($request, [
            'received_by'   => 'required'
        ]);

        $ts = TemporarySlip::find($id);

        $ts->update($request->except('_token','method'));

        return redirect()->back()->with('success',"Temporary slip has been updated!");

    }


    public function search(Request $request) {

        $user = auth()->user();

        $temporary_slips = TemporarySlip::where('ts_no', 'LIKE', "%{$request->ts_no}%")
            ->where('status','approved')
            ->where('running_balance', '>', 0)
            ->whereHas('user', function(Builder $builder) use($user) {
                $builder->where('assign_to', $user->assign_to);
            })
            ->get();

        return $temporary_slips;

    }


    public function statusUpdate($id, Request $request) {

        $ts = TemporarySlip::find($id);
        $ts->update(['status' => $request->action]);

        return redirect()->route('requestor.ts.index')->with(['success' => "{$ts->ts_no} was successfully submitted."]);

    }


    public function print($id) {

        $ts = TemporarySlip::find($id);

        return view('pages.ts.requestor.print', compact('ts'));

    }

}
