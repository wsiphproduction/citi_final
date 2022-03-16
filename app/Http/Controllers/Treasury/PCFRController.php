<?php

namespace App\Http\Controllers\Treasury;

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
use App\Models\Branch;
use App\Models\User;

class PCFRController extends Controller
{


    public function index() {

        $user = auth()->user();

        $pcfr = Pcfr::whereHas('user', function(Builder $builder) {
            $builder->where('assign_to', auth()->user()->assign_to);
        })->get();

        return view('pages.pcfr.treasury.index', compact('pcfr'));

    }


    public function forApproval() {

        $user = auth()->user();

        $pcfr = Pcfr::where('status', 'submitted')
            ->whereHas('user', function(Builder $builder) {
                $builder->where('assign_to', auth()->user()->assign_to);
            })->get();

        return view('pages.pcfr.treasury.for-approval', compact('pcfr'));

    }


    public function tempSlips() {

        $temp_slips = TemporarySlip::where('status', 'approved')
            ->whereHas('user', function(Builder $builder) {
                $builder->where('assign_to', auth()->user()->assign_to);
            })->get();

        return view('pages.pcfr.treasury.temp-slips', compact('temp_slips'));

    }


    public function pcvs() {

        $pcvs = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $builder) {
                $builder->where('assign_to', auth()->user()->assign_to);
            })->get();

        return view('pages.pcfr.treasury.pcv', compact('pcvs'));

    }


    public function create() {

        $vendors = Branch::select('company_name')->where('status', 1)->distinct('company_name')->get();
        $user = auth()->user();
        $branch = $user->branch;

        // Unliquidated ts
        $unliquidated_ts = TemporarySlip::where('running_balance', '>', 0)
            ->where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });
        // for replenishment
        $for_rep_pcfr = Pcfr::where('status', 'for replenishment')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });
        // Pending Replenishment 
        $pending_rep_pcv = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });
        // Unreplenished
        $unreplenished = Pcfr::where('status', 'unreplenishment')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });
        // Unapproved pcv
        $unapproved_pcvs = Pcv::where('status', 'disapproved tl')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });
        // Returned pcv
        $returned_pcvs = Pcv::where('status', 'cancelled');
        // pcvs 
        $pcvs = Pcv::where('status', 'approved');

        $cash_on_hand = 0;
        $atm_bal = 0;

        // PCF Accountability
        $pcv_accountability = $branch->budget;


        // For replenishment
        $for_replenishment1 = $for_rep_pcfr->sum('amount');
        // pending for replenishment
        $pending_rep_pcv1 = $pending_rep_pcv->sum('amount');
        // unreplenished
        $unreplenished1 = $unreplenished->sum('amount');
        // unapproved pcv
        $unapproved_pcvs1 = $unapproved_pcvs->sum('amount');
        // return pcv
        $returned_pcvs1 = $returned_pcvs->sum('amount');
        // unliquidated ts
        $unliquidated_ts1 = $unliquidated_ts->sum('running_balance');

        // PCF Accounted For
        $pcv_accounted = $unliquidated_ts1 + $for_replenishment1 + $atm_bal + $cash_on_hand + $pending_rep_pcv1 + $unreplenished1 + $returned_pcvs1;

        // overage / shortage
        $overage_shortage = $pcv_accountability - $pcv_accounted;

        // pcv_first
        $pcv_first = $pending_rep_pcv->first();
        // pcv_last
        $pcv_last = $pending_rep_pcv->latest()->first();
        // pcvs
        $pcvs = $pcvs->get();

        $pcvs_sum = $pcvs->sum('amount');

        return view('pages.pcfr.treasury.create', compact('vendors', 'pcvs', 'for_replenishment1', 
                'pcv_first', 'pcv_last', 'overage_shortage', 'pcvs_sum', 'pending_rep_pcv1', 'unreplenished1', 
                'unapproved_pcvs1', 'returned_pcvs1', 'unliquidated_ts1', 'pcv_accountability', 'pcv_accounted'));

    }


    public function store(Request $request) {

        $attachments = json_decode($request->pcfr_attachments, true);
        $pcv_ids = json_decode($request->pcv_ids, true);
        $user = auth()->user();

        $pcfr = Pcfr::create([
            'pcfr_no'                       => $request->pcfr_no ,
            'batch_no'                      => $request->batch_no ,
            'date_created'                  => \Carbon\Carbon::parse($request->date_created) ,
            'branch'                        => $request->branch ,
            'doc_type'                      => $request->doc_type , 
            'vendor'                        => $request->vendor ,
            'from'                          => \Carbon\Carbon::parse($request->period_date_from) ,
            'to'                            => \Carbon\Carbon::parse($request->period_date_to) ,
            'total_temp_slip'               => $request->temporary_slip ,
            'total_replenishment'           => $request->total_replenishment ,
            'total_unreplenished'           => $request->unreplenished ,
            'total_unapproved_pcv'          => $request->unapproved_pcvs ,
            'total_returned_pcv'            => $request->returned_pcvs ,
            'total_accounted'               => $request->pcf_accounted_for ,
            'pcf_accountability'            => $request->pcf_accountability ,
            'total_pending_replenishment'   => $request->pending_replenishment ,
            'pcf_diff'                      => $request->overage_shortage ,
            'atm_balance'                   => $request->atm_balance ,
            'cash_on_hand'                  => $request->cash_on_hand ,
            'status'                        => $request->status ,
            'user_id'                       => auth()->user()->id ,
            'amount'                        => $request->amount
        ]);

        if(count($pcv_ids)) {

            foreach( $pcv_ids as $id ) {

                $pcv = Pcv::find($id);
                $pcv->pcfr_id = $pcfr->id;
                $pcv->save();

            }

        }

        if(count($attachments)) {

            foreach( $attachments as $attachment ) {

                foreach( $attachments as $attachment ) {

                if($attachment['attachment'] == '') continue;

                Attachment::create([
                    'from'          => 'pcfr' ,
                    'from_ref'      => $pcfr->id , 
                    'type'          => $attachment['type'] ,
                    'ref'           => $attachment['ref'] ,
                    'date'          => \Carbon\Carbon::parse($attachment['date']) ,
                    'attachment'    => $attachment['attachment'] 
                ]);

                Storage::move("public/temp/{$user->id}/pcfr/{$attachment['attachment']}", 
                    "public/pcfr/{$pcfr->pcfr_no}/{$attachment['attachment']}");

            }

            }

        }

        return redirect()->route('requestor.pcfr.index')->with('success','PCFR has been created!');

    }


    public function showPcfr($pcfr) {

        $pcfr = Pcfr::where('pcfr_no', $pcfr)
            ->with('pcv', 'attachments')
            ->first();

        $area_manager = User::where('position', 'treasury head')
            ->where('assign_to', auth()->user()->assign_to)
            ->get();

        return view('pages.pcfr.treasury.show-pcfr', compact('pcfr', 'area_manager'));

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
            'remarks'           => $request->remarks ,
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
