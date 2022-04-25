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
            })
            ->orderBy('created_at', 'DESC')
            ->get();

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


    public function print($id) {

        $pcfr = Pcfr::find($id);

        return view('pages.pcfr.treasury.print', compact('pcfr'));

    }


    public function create() {

        $vendor = \DB::table('comp_branch_selection')
            ->where('BRANCH_CODE', auth()->user()->assign_to)
            ->first();

        $user = auth()->user();
        $branch = $user->branch;

        // PCF Accountability
        $pcv_accountability = $branch->budget;

        // unliquidated ts
        // $unliquidated_ts = TemporarySlip::where('running_balance', '>', 0)
        //     ->where('status', 'approved')
        //     ->whereHas('user', function(Builder $query) use ($user) {
        //         $query->where('assign_to', $user->assign_to);
        //     })->sum('running_balance');

        $total_replenishment = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->doesntHave('pcfr')->sum('amount');

        $pending_replenishment = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->doesntHave('pcfr')->sum('amount');

        $unreplenished = Pcfr::whereIn('status', ['post to ebs' ,'for replenishment'])
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

        $pcf_accounted_for = $total_replenishment + $pending_replenishment + $unreplenished + $unapproved_pcvs + $returned_pcvs;

        // overage / shortage
        $overage_shortage = $pcv_accountability - $pcf_accounted_for;

        $pcvs = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->doesntHave('pcfr')->get();


        $pcv_first = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->doesntHave('pcfr')->first();
        $pcv_last = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->doesntHave('pcfr')->latest()->first();

        $pcvs_sum = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->doesntHave('pcfr')->sum('amount');

        if(!$pcv_first) return redirect()->back()->with('danger', 'No pcv found. Please create pcv first.');

        return view('pages.pcfr.treasury.create', compact('vendor', 'pcvs', 'pcv_first', 'pcv_last', 'pcvs_sum',
                'overage_shortage', 'unreplenished', 'total_replenishment', 'pending_replenishment', 'pcf_accounted_for', 
                'unapproved_pcvs', 'returned_pcvs', 'pcv_accountability'));

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

                Storage::copy("public/temp/{$user->id}/pcfr/{$attachment['attachment']}", 
                    "public/pcfr/{$pcfr->pcfr_no}/{$attachment['attachment']}");

            }

            }

        }

        return redirect()->route('treasury.pcfr.index')->with('success','PCFR has been created!');

    }


    public function edit($id) {

        $pcfr = Pcfr::find($id);
        $vendor = \DB::table('comp_branch_selection')
            ->where('BRANCH_CODE', auth()->user()->assign_to)
            ->first();

        return view('pages.pcfr.treasury.edit', compact('pcfr', 'vendor'));

    }


    public function update($id, Request $request) {

        $attachments = json_decode($request->pcfr_attachments, true);
        $user = auth()->user();

        $pcfr = Pcfr::find($id);

        $pcfr->update([
            'vendor'                        => $request->vendor ,
            'total_accounted'               => $request->pcf_accounted_for ,
            'pcf_diff'                      => $request->overage_shortage ,
            'atm_balance'                   => $request->atm_balance ,
            'doc_type'                      => $request->doc_type , 
            'cash_on_hand'                  => $request->cash_on_hand ,
            'status'                        => $request->status ,
            'amount'                        => $request->amount
        ]);      

        $pcfr->attachments()->delete();

        if(count($attachments)) {

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

                if(Storage::exists("public/pcfr/{$pcfr->pcfr_no}/{$attachment['attachment']}")) {
                    Storage::delete("public/pcfr/{$pcfr->pcfr_no}/{$attachment['attachment']}");
                }

                Storage::copy("public/temp/{$user->id}/pcfr/{$attachment['attachment']}", 
                    "public/pcfr/{$pcfr->pcfr_no}/{$attachment['attachment']}");

            }


        }

        return redirect()->route('treasury.pcfr.index')->with('success','PCFR has been created!');

    }


    public function showPcfr($id) {

        $pcfr = Pcfr::find($id);

        $area_manager = User::where('position', 'treasury head')
            ->where('assign_to', auth()->user()->assign_to)
            ->get();

        return view('pages.pcfr.treasury.show-pcfr', compact('pcfr', 'area_manager'));

    }

    public function showPcv($id) {

        $pcv = Pcv::find($id);

        return view('pages.pcfr.treasury.show-pcv', compact('pcv'));

    }

    public function showTs($id) {

        $ts = TemporarySlip::find($id);

        return view('pages.pcfr.treasury.show-ts', compact('ts'));

    }


    public function disapprove($id, Request $request) {

        $pcfr = Pcfr::find($id);
        $pcfr->update([
            'status'            => 'disapproved' ,
            'cancelled_by'      => auth()->user()->username ,
            'cancelled_date'    => \Carbon\Carbon::now() ,
            'tl'                => 0 
        ]);

        return response()->json([
            'message'   => "PCFR No. {$pcfr->pcfr_no} is successfully Disapprove."
        ]);

    }


    public function approve($id, Request $request) {

        $pcfr = Pcfr::find($id);

        $pcfr->update([
            'tl_approved'       => 1 ,
            'status'            => 'approved' 
        ]);

        return response()->json([
            'need_code' =>  false ,
            'message'   => "PCFR No. {$pcfr->pcfr_no} is successfully approved."
        ]);

    }

    public function pcvRemove($id, Request $request) {

        $pcv = Pcv::find($id);
        $pcfr = Pcfr::find($pcv->pcfr_id);

        $pcv->update([
            'status'            => 'disapproved th' ,
            'remarks'           => $request->remarks ,
            'pcfr_id'           => null ,
            'tl_approved'       => null ,
            'dh_approved'       => null
        ]);

        $this->recomputePcfr($pcfr);
        
        return redirect()->back()->with('success', "PCFR No. {$pcv->pcv_no} is successfully removed");

    }

    public function recomputePcfr($pcfr) {

        $user = $pcfr->user;
        $branch = $user->branch;
        $cash_on_hand = 0;
        $atm_bal = 0;

        // PCF Accountability
        $pcv_accountability = $branch->budget;

        // for replenishment
        $for_replenishment = Pcv::where('status', 'approved')
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

        return back()->with(['success'  => "PCFR No. {$pcfr->pcfr_no} is successfully submitted."]);

    }
   
}
