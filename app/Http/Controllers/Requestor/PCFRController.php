<?php

namespace App\Http\Controllers\Requestor;

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

        $pcfr = Pcfr::where('user_id', auth()->user()->id)->get();

        return view('pages.pcfr.requestor.index', compact('pcfr'));

    }

    public function create() {

        $vendors = Vendor::where('status', 1)->get();
        $user = auth()->user();
        $branch = $user->branch;

        // Unliquidated ts
        $unliquidated_ts = TemporarySlip::where('running_balance', '>', 0)
            ->where('status', 'approved');
        // for replenishment
        $for_rep_pcfr = Pcfr::where('status', 'for replenishment');
        // Pending Replenishment 
        $pending_rep_pcv = Pcv::where('status', 'approved');
        // Unreplenished
        $unreplenished = Pcfr::where('status', 'unreplenishment');
        // Unapproved pcv
        $unapproved_pcvs = Pcv::where('status', 'disapproved tl');
        // Returned pcv
        $returned_pcvs = Pcv::where('status', 'cancelled');
        // pcvs 
        $pcvs = Pcv::where('status', 'approved');

        $cash_on_hand = 0;
        $atm_bal = 0;

        // PCF Accountability
        $pcv_accountability = $branch->budget;


        if( $user->getUserAssignTo() == 'ssc' ) {

            $for_replenishment = $for_rep_pcfr->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

            $pending_rep_pcv = $pending_rep_pcv->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

            $unreplenished = $unreplenished->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

            $unapproved_pcvs = $unapproved_pcvs->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

            $pcvs = $pcvs->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

            $unliquidated_ts = $unliquidated_ts->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

        } else {

            $for_replenishment = $for_rep_pcfr->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

            $pending_rep_pcv = $pending_rep_pcv->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

            $unreplenished = $unreplenished->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

            $unapproved_pcvs = $unapproved_pcvs->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

            $pcvs = $pcvs->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

            $unliquidated_ts = $unliquidated_ts->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

        }

        // For replenishment
        $for_replenishment1 = $for_replenishment->sum('amount');
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

        return view('pages.pcfr.requestor.create', compact('vendors', 'pcvs', 'for_replenishment1', 
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
            'amount'                        => 0
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


    public function show($pcfr) {

        $pcfr = Pcfr::where('pcfr_no', $pcfr)
            ->with('pcv', 'attachments')
            ->first();

        return view('pages.pcfr.requestor.show', compact('pcfr'));

    }


    public function statusUpdate($id, Request $request){

        $pcfr = Pcfr::find($id);
        $pcfr->update(['status'  => $request->action]);

        return back()->with(['success'  => "{$pcfr->pcfr_no} was successfully submitted."]);

    }


    public function generatepcrf(Request $request) {

        $from = \Carbon\Carbon::parse($request->from)->format('Y-m-d');
        $to   = \Carbon\Carbon::parse($request->to)->format('Y-m-d');

        $pcv = Pcv::where('status', 'approved')
            ->whereDate('date_created', '>=' , $from)
            ->whereDate('date_created', '<=', $to);

        $user = auth()->user();

        $ts = TemporarySlip::where('running_balance', '>', 0) 
            ->whereDate('date_created', '>=' , $from)
            ->whereDate('date_created', '<=', $to);

        $pcfr = Pcfr::where('status', 'for replenishment')
            ->whereDate('date_created', '>=' , $from)
            ->whereDate('date_created', '<=', $to);

        if( $user->getUserAssignTo() == 'ssc' ) {

            $pcv_new = $pcv->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

            $unliquidated_ts = $ts->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

            $for_replenishment = $pcfr->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to)
                    ->where('assign_name', $user->assign_name);
            });

        } else {

            $pcv_new = $pcv->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

            $unliquidated_ts = $ts->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

            $for_replenishment = $pcfr->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            });

        }

//        $pcvs = $pcv_new->with('user.branch')->get();
        $unliquidated_ts = $unliquidated_ts->sum('running_balance');
        $for_replenishment = $for_replenishment->sum('amount');

        return response()->json([
            'pcvs'  => count($pcvs) ? $pcvs : 0 ,
            'unliquidated_ts'       => $unliquidated_ts ,
            'for_replenishment'     => $for_replenishment ,
            'pending_replenishment' => 5 ,
            'unreplenished'         => 0 ,
            'unapproved_pcvs'       => 0 ,
            'returned_pcvs'         => 0 ,
            'pcf_accounted_for'     => 0 , 
            'over_short'            => 0 ,
            'pcf_accountability'    => 0
        ]);

    }

}
