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
        
        $pcfr = Pcfr::where('status', 'approved')
            ->where('tl_approved', 1)
            ->whereHas('user', function(Builder $query) {
                    $query->where('assign_to', auth()->user()->assign_to);
            })   
            ->get();

        return view('pages.pcfr.payable.index', compact('pcfr'));

    }


    public function forReplenished() {

        $pcfr = Pcfr::where('status', 'posted to ebs')
            ->whereHas('user', function(Builder $builder) {
                $builder->where('assign_to', auth()->user()->assign_to);
            })
            ->get();

        return view('pages.pcfr.payable.for-replenished', compact('pcfr'));

    }


    public function replenished() {

        $pcfr = Pcfr::where('status', 'replenished')
            ->whereHas('user', function(Builder $builder) {
                $builder->where('assign_to', auth()->user()->assign_to);
            })
            ->get();

        return view('pages.pcfr.payable.replenished', compact('pcfr'));

    }


    public function show($pcfr) {

        $pcfr = Pcfr::where('pcfr_no', $pcfr)
            ->with('pcv', 'attachments')
            ->first();

        return view('pages.pcfr.payable.show', compact('pcfr'));

    }


    public function disapprove($id, Request $request) {

        $pcfr = Pcfr::find($id);
        $pcfr->update([
            'status'            => 'disapproved' ,
            'cancelled_by'      => auth()->user()->username ,
            'cancelled_date'    => \Carbon\Carbon::now() ,
            'py_staff_approved' => 0 
        ]);

        return response()->json([
            'message'   => "{$pcfr->pcfr_no} was successfully Disapprove."
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
            'message'   => "{$pcfr->pcfr_no} was successfully approved."
        ]);

    }

    public function pcvRemove($id, Request $request) {

        $pcv = Pcv::find($id);
        $pcv->update([
            'status'            => 'cancelled' ,
            'cancelled_by'      => auth()->user()->username ,
            'cancelled_date'    => \Carbon\Carbon::now() ,
            'remarks'           => $pcv->remarks . " > " . $request->remarks ,
            'pcfr_id'           => null
        ]);

        // update pcfr auto calculations
        $pcfr = Pcfr::find($request->pcfr_no);
        $this->recomputePcfr($pcfr);

        return redirect()->back()->with('success', "{$pcv->pcv_no} successfully removed");

    }


    public function recomputePcfr($pcfr) {

        $user = auth()->user();
        $branch = $user->branch;
        $cash_on_hand = 0;
        $atm_bal = 0;

        // PCF Accountability
        $pcv_accountability = $branch->budget;

        // for replenishment
        $for_replenishment = Pcfr::where('status', 'for replenishment')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');

        // Pending Replenishment 
        $pending_rep_pcv = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })
            ->sum('amount');

        // Unreplenished
        $unreplenished = Pcfr::where('status', 'unreplenished')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })
            ->sum('amount');

        // Unapproved pcv
        $unapproved_pcvs = Pcv::where('status', 'disapproved tl')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');

        // Unliquidated ts
        $unliquidated_ts = TemporarySlip::where('running_balance', '>', 0)
            ->where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('running_balance');

        // Returned pcv
        $returned_pcvs = Pcv::where('status', 'cancelled')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })
            ->sum('amount');
        

        // PCF Accounted For
        $pcv_accounted = $unliquidated_ts + $for_replenishment + $atm_bal + $cash_on_hand + $pending_rep_pcv + $unreplenished + $returned_pcvs + $unapproved_pcvs;

        // overage / shortage
        $overage_shortage = $pcv_accountability - $pcv_accounted;

        // pcvs 
        $pcvs = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');

        $pcfr->update([
            'total_temp_slip'               => $unliquidated_ts ,
            'total_replenishment'           => $for_replenishment ,
            'total_unreplenished'           => $unreplenished ,
            'total_unapproved_pcv'          => $unapproved_pcvs ,
            'total_returned_pcv'            => $returned_pcvs ,
            'total_accounted'               => $pcv_accounted ,
            'total_pending_replenishment'   => $pending_rep_pcv ,
            'pcf_diff'                      => $overage_shortage
        ]);

    }


    public function statusUpdate($id, Request $request){

        $pcfr = Pcfr::find($id);
        $pcfr->update(['status'  => $request->action]);

        return back()->with(['success'  => "{$pcfr->pcfr_no} was successfully submitted."]);

    }
   
}
