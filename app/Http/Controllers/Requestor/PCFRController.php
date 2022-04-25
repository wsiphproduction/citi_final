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

        $user = auth()->user();

        $pcfr = Pcfr::whereIn('status', [
                'saved' , 'submitted', 'approved', 'for replenishment', 'replenished', 'disapproved tl', 'disapproved py', 'post to ebs'
            ])->whereHas('user', function(Builder $builder) use($user) {
                $builder->where('assign_to', $user->assign_to);
            })
            ->orderBy('date_created', 'DESC')
            ->get();

        return view('pages.pcfr.requestor.index', compact('pcfr'));

    }

    public function create() {

        $vendor = \DB::table('comp_branch_selection')
            ->where('BRANCH_CODE', auth()->user()->assign_to)
            ->first();

        $user = auth()->user();
        $branch = $user->branch;

        // PCF Accountability
        $pcv_accountability = $branch->budget;

        // Temp Slip with running bal > 0
        // $unliquidated_ts = TemporarySlip::where('running_balance', '>', 0)
        //     ->where('status', 'approved')
        //     ->whereHas('user', function(Builder $query) use ($user) {
        //         $query->where('assign_to', $user->assign_to);
        //     })->sum('running_balance');


        // PCFR with status approved
        $total_replenishment = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })
            ->whereDoesntHave('pcfr')
            ->sum('amount');


        // PCV with status approve w/out pcfr
        $pending_replenishment = Pcv::where('status', 'approved')
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->whereDoesntHave('pcfr')->sum('amount');


        // PCFR with status for replishment
        $unreplenished = Pcfr::whereIn('status', ['post to ebs', 'for replenishment'])
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');            


        // PCV with status disapprove on TL || Dept Head
        $unapproved_pcvs = Pcv::whereIn('status', ['disapproved tl', 'disapproved dh'])
            ->whereHas('user', function(Builder $query) use ($user) {
                $query->where('assign_to', $user->assign_to);
            })->sum('amount');


        // PCV with status disapproved py
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

        return view('pages.pcfr.requestor.create', compact('vendor', 'pcvs', 'pcv_first', 'pcv_last', 'pcvs_sum',
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

        return redirect()->route('requestor.pcfr.index')->with('success','PCFR has been created!');

    }


    public function show($id) {

        $pcfr = Pcfr::find($id);

        return view('pages.pcfr.requestor.show', compact('pcfr'));

    }

    public function edit($id) {

        $pcfr = Pcfr::find($id);
        $vendor = \DB::table('comp_branch_selection')
            ->where('BRANCH_CODE', auth()->user()->assign_to)
            ->first();

        return view('pages.pcfr.requestor.edit', compact('pcfr', 'vendor'));

    }

    public function print($id) {

        $pcfr = Pcfr::find($id);

        return view('pages.pcfr.requestor.print', compact('pcfr'));

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

        return redirect()->route('requestor.pcfr.index')->with('success','PCFR has been created!');

    }


    public function statusUpdate($id, Request $request){

        $pcfr = Pcfr::find($id);
        $pcfr->update(['status'  => $request->action]);

        return back()->with(['success'  => "PCFR No. {$pcfr->pcfr_no} was successfully submitted."]);

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
