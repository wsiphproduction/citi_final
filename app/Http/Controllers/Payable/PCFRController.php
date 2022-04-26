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
            'cancelled_by'      => auth()->user()->username ,
            'cancelled_date'    => \Carbon\Carbon::now() ,
            'py_staff_approved' => 0 
        ]);

        return response()->json([
            'message'   => "PCFR No. {$pcfr->pcfr_no} was successfully Disapprove."
        ]);

    }


    public function approve($id, Request $request) {

        $pcfr = Pcfr::find($id);

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
