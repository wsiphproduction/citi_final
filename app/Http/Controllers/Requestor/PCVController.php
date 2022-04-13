<?php

namespace App\Http\Controllers\Requestor;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Pcv;
use App\Models\User;
use App\Models\Branch;
use App\Models\Attachment;
use App\Models\TemporarySlip;
use Illuminate\Validation\Rule;
use App\Models\AccountTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
    
class PCVController extends Controller
{


    public function index() {
        $user = auth()->user();
        $pcvs = Pcv::whereIn('status', [
            'saved', 'approved', 'submitted','confirmed', 'cancel', 'cancelled', 'disapproved','disapproved tl', 
            'disapproved dept head', 'disapproved dh', 'disapproved py'
        ])->whereHas('user' , function(Builder $builder) use($user) {
                if($user->getUserAssignTo() == 'ssc') {
                    $builder->where('assign_to', $user->assign_to)
                        ->where('assign_name', $user->assign_name);
                } else {
                    $builder->where('assign_to', $user->assign_to);
                }
            })
            ->doesntHave('pcfr')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.pcv.requestor.index', compact('pcvs'));

    }


    public function show($id) {

        $pcv = Pcv::find($id);

        return view('pages.pcv.requestor.show', compact('pcv'));

    }

    public function copyPCV($pcv) {

        $pcv = Pcv::where('pcv_no', $pcv)
            ->with(['account_transaction'])
            ->first();

        return response()->json($pcv);

    }

    public function create() {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);
        $ts = TemporarySlip::where('status', 'approved')
            ->where('running_balance', '>', 0)
            ->whereHas('user', function($query) {
                $query->where('assign_to', auth()->user()->assign_to);
            })->get();

        $area_manager = User::where('position', 'area head')
            ->whereHas('branch_group', function($query) {
                $branch = auth()->user()->branch;
                $query->where('branch', 'LIKE', "%{$branch->name}%");
            })->get();

        return view('pages.pcv.requestor.create', compact('accounts', 'area_manager', 'ts'));

    }


    public function store(Request $request) {

        $attachments = json_decode($request->pcv_attachments, true);
        $account_transactions = json_decode($request->pcv_accounts, true);
        $total_amount = 0;
        $user = auth()->user();

        $this->validate($request, [
            'ts_no'     => [ 
                Rule::requiredIf($request->has('withslip')),  
                Rule::exists('temporary_slips')
                    ->where(function($query) use ($request) {
                        return $query->where('ts_no', '=', $request->ts_no);
                    })
                ] ,
            'account_name'  => 'required',
            'description'   => 'required'
        ]);

        $_exists = Pcv::where('pcv_no', $request->ts_no)
            ->whereHas('user', function($query){
                $query->where('assign_to', auth()->user()->assign_to);
            })->first();

        if($_exists) return back()->withInput()->with('danger', 'TS No. Already exists');
        
        if($request->has('withslip')) {

            $ts = TemporarySlip::where('ts_no', $request->ts_no)
                ->whereHas('user', function($query){
                    $query->where('assign_to', auth()->user()->assign_to);
                })
                ->first();

            $r_bal = $ts->running_balance  -  ( $request->total_amount - $request->change );
            if( $r_bal < 0 ) {
                return redirect()->back()->withInput()->with('danger', 'TS amount is less than the amount inputed on the account');
            }

            $ts->running_balance = $r_bal;
            $ts->save();            

        }

        // save pcv transaction
        $pcv_transaction = Pcv::create([
            'account_name'  => $request->account_name == 'others' || $request->account_name == 'Others' ? $request->account_name_other : $request->account_name ,
            'change'        => $request->change ,
            'date_created'  => $request->date_created ,
            'pcv_no'        => Pcv::generatePCVNumber() ,
            'slip_no'       => $request->has('withslip') ? $request->ts_no : null ,
            'status'        => $request->pcv_action ,
            'user_id'       => auth()->user()->id ,
            'description'   => $request->description
        ]);

        // add pcv reference to attachments
        
        // add pcv reference to account transactions
        if(count($account_transactions)) {

            $account_transaction = AccountTransaction::create([
                'name'          => $request->account_name == 'others' || $request->account_name == 'Others' ? $request->account_name_other : $request->account_name ,
                'details'       => $account_transactions , 
                'pcv_id'        => $pcv_transaction->id ,
                'status'        => 'approved' 
                // ,
                // 'approval_code' => array_key_exists('code', $account_transaction) ? $account_transaction['code'] : null ,
                // 'approved_by'   => array_key_exists('by', $account_transaction) ? $account_transaction['by'] : null ,
                // 'approved_date' => array_key_exists('date', $account_transaction) ? $account_transaction['date'] : null ,
                // 'remarks'       => array_key_exists('remarks', $account_transaction) ? $account_transaction['remarks'] : null 
            ]);

        }

        // move attachment from temporary folder to original folder
        if(count($attachments)) {

            foreach( $attachments as $attachment ) {

                if($attachment['attachment'] == '') continue;

                Attachment::create([
                    'from'          => 'pcv' ,
                    'from_ref'      => $pcv_transaction->id , 
                    'type'          => $attachment['type'] ,
                    'ref'           => $attachment['ref'] ,
                    'date'          => \Carbon\Carbon::parse($attachment['date']) ,
                    'attachment'    => $attachment['attachment'] 
                ]);

                if(Storage::exists("public/pcv/{$pcv_transaction->pcv_no}/{$attachment['attachment']}")) {
                    Storage::delete("public/pcv/{$pcv_transaction->pcv_no}/{$attachment['attachment']}");
                }

                Storage::copy("public/temp/{$user->id}/pcv/{$attachment['attachment']}", 
                    "public/pcv/{$pcv_transaction->pcv_no}/{$attachment['attachment']}");

                //Storage::deleteDirectory("public/temp/{$pcv_transaction->pcv_no}");

            }

        }

        $pcv_transaction->amount = $request->total_amount;
        $pcv_transaction->save();

        return redirect()->route('requestor.pcv.index')->with('success',"PCV Request was successfully {$request->pcv_action}");

    }

    public function edit($pcv) {

        $pcv = Pcv::find($pcv);
        $ts = TemporarySlip::where('status', 'approved')
            ->whereHas('user', function($query) {
                $query->where('assign_to', auth()->user()->assign_to);
            })->get();
        $area_manager = User::where('position', 'area head')
            ->whereHas('branch_group', function($query) {
                $branch = auth()->user()->branch;
                $query->where('branch', 'LIKE', "%{$branch->name}%");
            })->get();

        return view('pages.pcv.requestor.edit', compact('pcv', 'area_manager', 'ts'));

    }

    public function update($id, Request $request) {

        $pcv = Pcv::find($id); 

        if($request->pcv_action == 'cancel') {

            $pcv->update([
                'status'    => 'cancel'
            ]);

            return redirect()->route('requestor.pcv.index')->with('success','Request to cancel PCV has been submitted!');

        }

        $this->validate($request, [
            'ts_no'     => [ 
                Rule::requiredIf($request->has('withslip')),  
                Rule::exists('temporary_slips')
                    ->where(function($query) use ($request) {
                        return $query->where('ts_no', '=', $request->ts_no);
                    })
                ] ,
            'description'   => 'required'
        ]);

        
        $user = auth()->user();

        $attachments = json_decode($request->pcv_attachments, true);
        $account_transactions = json_decode($request->pcv_accounts, true);
        $total_amount = 0;

        // revert back the ts balance 
        // if diff ts used upon updating       
        if(!is_null($pcv->slip_no)) {

            $ts = TemporarySlip::where('ts_no', $pcv->slip_no)->first();
            $last_log = $ts->audits()->latest()->first();

            if(array_key_exists("running_balance", $last_log->old_values)) {
                $ts->running_balance = $last_log->old_values['running_balance'];
                $ts->save();        
            }
        }

        if($request->has('withslip')) {

            $ts = TemporarySlip::where('ts_no', $request->ts_no)->first();

            $r_bal = $ts->running_balance  -  ( $request->total_amount - $request->change );

            if( $r_bal < 0 ) {
                return redirect()->back()->withInput()->with('danger', 'TS amount is less than the amount inputed on the account');
            }

            $ts->running_balance = $r_bal;
            $ts->save();            

        }

        $pcv->attachments()->delete();
        $pcv->account_transaction()->delete();
        $pcv->update([
            'account_name'  => $request->account_name == 'others' || $request->account_name == 'Others' ? $request->account_name_other : $request->account_name ,
            'change'        => $request->change ,
            'date_created'  => $request->date_created ,
            'slip_no'       => $request->has('withslip') ? $request->ts_no : null ,
            'status'        => $request->pcv_action ,
            'user_id'       => auth()->user()->id ,
            'description'   => $request->description
        ]);

        // add pcv reference to attachments
        // move attachment from temporary folder to original folder
        if(count($attachments)) {

            foreach( $attachments as $attachment ) {

                if($attachment['attachment'] == '') continue;

                Attachment::create([
                    'from'          => 'pcv' ,
                    'from_ref'      => $pcv->id , 
                    'type'          => $attachment['type'] ,
                    'ref'           => $attachment['ref'] ,
                    'date'          => \Carbon\Carbon::parse($attachment['date']) ,
                    'attachment'    => $attachment['attachment'] 
                ]);

                if(Storage::exists("public/pcv/{$pcv->pcv_no}/{$attachment['attachment']}")) {
                    Storage::delete("public/pcv/{$pcv->pcv_no}/{$attachment['attachment']}");
                }

                Storage::copy("public/temp/{$user->id}/pcv/{$attachment['attachment']}", 
                    "public/pcv/{$pcv->pcv_no}/{$attachment['attachment']}");

            }

        }

        // add pcv reference to account transactions
        if(count($account_transactions)) {
            
            AccountTransaction::create([
                'name'          => $request->account_name == 'others' || $request->account_name == 'Others' ? $request->account_name_other : $request->account_name,
                'details'       => $account_transactions , 
                'pcv_id'        => $pcv->id ,
                'status'        => 'approved' 
            ]);

        }

        $pcv->amount = $request->total_amount;
        if($request->pcv_action=='submitted') {
            $pcv->tl_approved = null;
            $pcv->dh_approved = null;
        }
        $pcv->save();

        return redirect()->route('requestor.pcv.index')->with('success',"PCV No. {$pcv->pcv_no} has been updated!");

    }

    public function statusUpdate($id, Request $request){

        $pcv = Pcv::find($id);
        $pcv->update(['status'  => $request->action]);

        return back()->with(['success'  => "PCV No. {$pcv->pcv_no} is successfully submitted."]);

    }


    public function statusUpdate1($id, Request $request){

        $pcv = Pcv::find($id);
        $pcv->update(['status'  => $request->action]);

        return response()->noContent();

    }


    public function receivedPcv($id, Request $request) {

        $pcv = Pcv::find($id);
        $pcv->update([
            'received_by'       => $request->name ,
            'received_date'     => $request->date
        ]);

        return response()->json([
            'message'   => "{$pcv->pcv_no} was successfully received."
        ]);

    }


    public function cancelled() {

        $pcv = Pcv::whereIn('status', ['cancelled'])
            ->whereHas('user', function(Builder $builder) {
                $builder->where('assign_to', auth()->user()->assign_to);
            })
            ->with(['account_transaction'])
            ->get();

        return response()->json($pcv);

    }

    public function checkBillingDate(Request $request) {

        $pcvs = Pcv::where('account_name', 'Staff House Rental')
            ->whereHas('user',  function(Builder $builder ) {
                $builder->where('assign_to', auth()->user()->assign_to);
            })
            ->with('account_transaction')
            ->get();
        $hasHit = false;

        foreach($pcvs as $pcv) {

            $_from = \Carbon\Carbon::parse($pcv->account_transaction->details[0]['bill_date_from']);
            $_to = \Carbon\Carbon::parse($pcv->account_transaction->details[0]['bill_date_to']);
            $from = \Carbon\Carbon::parse($request->from);
            $to = \Carbon\Carbon::parse($request->to);

            if($from->between($_from, $_to) || $to->between($_from, $_to)) {
                $hasHit = true;
                continue;
            }

        }

        if($hasHit) { return 'yes'; }

        return 'no';

    }

    public function print($id) {

        $pcv = Pcv::find($id);

        return view('pages.pcv.requestor.print', compact('pcv'));

    }


    public function pcvSigned($id, Request $request) {

        $pcv = Pcv::find($id);
        $user = auth()->user();
        Attachment::create([
            'from'  => 'pcv' ,
            'from_ref'  => $pcv->id ,
            'type'  => $request->type , 
            'ref'   => $request->docref ,
            'date'  => $request->docdate ,
            'attachment'    => $request->docrefstring
        ]);

        if(Storage::exists("public/pcv/{$pcv->pcv_no}/{$request->docrefstring}")) {
            Storage::delete("public/pcv/{$pcv->pcv_no}/{$request->docrefstring}");
        }

        Storage::copy("public/temp/{$user->id}/pcv/{$request->docrefstring}", 
            "public/pcv/{$pcv->pcv_no}/{$request->docrefstring}");

        return back()->with(['success'  => "PCV Signed Document is successfully attachment on {$pcv->pcv_no}."]);

    }


}
