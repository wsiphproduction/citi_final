<?php

namespace App\Http\Controllers\Payable;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Pcv;
use App\Models\Pcfr;
use App\Models\TemporarySlip;
use App\Models\Attachment;
use App\Models\APHeader;
use App\Models\APLine;
use App\Models\ARHeader;
use App\Models\ARLine;
use App\Models\User;

class PCFRController extends Controller
{


    public function index() {
    
        $user = auth()->user();

        $pcfr = Pcfr::where('tl_approved', 1)
            ->orderBy('created_at', 'DESC')  
            ->get();

        return view('pages.pcfr.payable.index', compact('pcfr'));

    }


    public function forReplenished() {

        $pcfr = Pcfr::where('status', 'post to ebs')
            ->get();

        return view('pages.pcfr.payable.for-replenished', compact('pcfr'));

    }


    public function replenished() {

        $pcfr = Pcfr::where('status', 'replenished')
            ->get();

        return view('pages.pcfr.payable.replenished', compact('pcfr'));

    }


    public function show($id) {

        $pcfr = Pcfr::find($id);

        return view('pages.pcfr.payable.show', compact('pcfr'));

    }


    public function disapprove($id, Request $request) {

        $pcfr = Pcfr::find($id);
        $pcfr->update([
            'status'            => 'disapproved py' ,
            'py_staff_approved' => 0 
        ]);

        return response()->json([
            'message'   => "PCFR No. {$pcfr->pcfr_no} was successfully Disapprove."
        ]);

    }


    public function approve($id, Request $request) {

        $pcfr = Pcfr::find($id);
        $pcfr_api_branch = \DB::table('api_branch')->where('store_code', User::find($pcfr->user_id)->assign_to)
                ->first();
        $pcfr_api_branch = json_decode(json_encode($pcfr_api_branch), true);

        $apheader = new APHeader;
        $apheader->operating_unit = $pcfr->user->branch->company_name;
        $apheader->batch_name = $pcfr->batch_no;
        $apheader->type = 'standard';
        $apheader->trading_partner = $pcfr->vendor;
        $apheader->supplier_num = 'new_column_segment_on_branch';
        $apheader->supplier_sitename = $pcfr_api_branch['ASSIGNED_STORE'];
        $apheader->invoice_date = \Carbon\Carbon::now();
        $apheader->invoicenum = $pcfr->pcfr_no;
        $apheader->invoice_currency = null;
        $apheader->invoice_amount = $pcfr->amount;
        $apheader->gl_date = \Carbon\Carbon::now();
        $apheader->payment_currency = null;
        $apheader->payment_date = null;
        $apheader->description = "{$pcfr->from} - {$pcfr->to} {$pcfr->user->firstname} {$pcfr->user->lastname}  {$pcfr->approved_by} with {$pcfr->pcf_diff}";
        $apheader->match_action = "receipt";
        $apheader->terms_date = null;
        $apheader->terms = "immediate";
        $apheader->payment_method = null;
        $apheader->inhouse_status = "completed";
        $apheader->oracle_status = null;
        $apheader->save();
        
        $latest_apheader = APHeader::latest()->first();

        foreach( $pcfr->pcv as $pcv ) {

            $pcv_user = User::find($pcv->user_id)->first();
            $pcv_api_branch = \DB::table('api_branch')->where('store_code', User::find($pcfr->user_id)->assign_to)
                ->first();
            $pcv_api_branch = json_decode(json_encode($pcv_api_branch), true);
            $accounts = \App\Models\Account::getUnsortedAccounts();
            $account_key = array_search("{$pcv->account_name}", array_column($accounts, 'name'));
            $account_details = $accounts[$account_key];

            $apline = new APLine;
            $apline->ap_header_id = $latest_apheader->id;
            $apline->amount = $pcv->amount;
            $apline->company = $pcv_api_branch['COMPANYID'];
            $apline->branch = $pcv->user->branch->store_id;
            $apline->accountno = $account_details['FLEX_VALUE_MEANING']; // check from list of accounts
            $apline->department = $pcv->user->getUserAssignTo() == 'ssc' ? $pcv->user->assign_name : '0000';
            $apline->intercompany = '00';
            $apline->sigment1 = '00';
            $apline->sigment2 = '0000';
            $apline->description = "{$pcv->pcv_no} {$pcv->approved_date} {$pcv->account_transaction->details[0]['vendor']} {$pcv->description}";
            $apline->gl_date = null;
            $apline->type = 'item';
            $apline->track_as_asset = null;
            $apline->asset_book = null;
            $apline->asset_category = null;
            $apline->reference1 = null;
            $apline->reference2 = null;
            $apline->save();

        }

        $pcfr->update([
            'py_staff_approved'     => 1 ,
            'status'                => 'post to ebs' 
        ]);

        return response()->json([
            'need_code' =>  false ,
            'message'   => "PCFR No. {$pcfr->pcfr_no} was successfully approved."
        ]);

    }

    public function pcvRemove($id, Request $request) {

        $pcv = Pcv::find($id);
        $pcfr = Pcfr::find($pcv->pcfr_id);

        $pcv->update([
            'status'            => 'disapproved py' ,
            'remarks'           => $request->remarks ,
            'pcfr_id'           => null ,
            'tl_approved'       => null ,
            'dh_approved'       => null
        ]);
        
        $this->recomputePcfr($pcfr);

        return redirect()->back()->with('success', "PCV No. {$pcv->pcv_no} successfully removed");

    }


    public function recomputePcfr($pcfr) {

        $user = $pcfr->user;
        $branch = $user->branch;
        $cash_on_hand = 0;
        $atm_bal = 0;

        // PCF Accountability
        $pcv_accountability = $branch->budget;

        // unliquidated ts
        // $unliquidated_ts = TemporarySlip::where('running_balance', '>', 0)
        //     ->where('status', 'approved')
        //     ->whereHas('user', function(Builder $query) use ($user) {
        //         $query->where('assign_to', $user->assign_to);
        //     })->sum('running_balance');

        $total_replenishment = Pcv::whereIn('status', ['post to ebs', 'for replenishment'])
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })
            ->whereHas('pcfr', function($query) use ($pcfr) {
                $query->where('pcfr_id', $pcfr->id);
            })
            ->sum('amount');

        $pending_replenishment = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })
            ->whereHas('pcfr', function($query) use ($pcfr) {
                $query->where('pcfr_id', $pcfr->id);
            })
            ->sum('amount');

        $unreplenished = Pcfr::whereIn('status', ['post to ebs', 'for replenishment'])
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');            

        $unapproved_pcvs = Pcv::whereIn('status', ['disapproved tl', 'disapproved dh'])
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');

        $returned_pcvs = Pcv::where('status', 'disapproved py')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');            

        $pcf_accounted_for = $pcfr->total_temp_slip + $total_replenishment + $pending_replenishment + $unreplenished + $unapproved_pcvs + $returned_pcvs + $pcfr->atm_balance + $pcfr->cash_on_hand;

        // overage / shortage
        $overage_shortage = $pcv_accountability - $pcf_accounted_for;

        $pcfr->update([
            'total_replenishment'           => $total_replenishment ,
            'total_unreplenished'           => $unreplenished ,
            'total_unapproved_pcv'          => $unapproved_pcvs ,
            'total_returned_pcv'            => $returned_pcvs ,
            'total_accounted'               => $pcf_accounted_for ,
            'total_pending_replenishment'   => $pending_replenishment ,
            'pcf_diff'                      => $overage_shortage
        ]);

    }


    public function statusUpdate($id, Request $request){

        $pcfr = Pcfr::find($id);
        $pcfr->update(['status'  => $request->action]);

        return back()->with(['success'  => "PCFR No. {$pcfr->pcfr_no} was successfully submitted."]);

    }
   
}
