<?php

namespace App\Http\Controllers\Approver;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Pcv;
use App\Models\Branch;
use App\Models\User;
use App\Models\Pcfr;
use App\Models\TemporarySlip;
use App\Models\Attachment;
use App\Models\AccountMatrix;

class PCFRController extends Controller
{


    public function index() {

        $user = auth()->user();
       
        $pcfr = Pcfr::whereNull('tl_approved')
                ->whereHas('user', function(Builder $query) use ($user) {
                    $query->where('assign_to', $user->assign_to);
                })
                ->orderBy('created_at', 'DESC')
                ->get();

        return view('pages.pcfr.approver.index', compact('pcfr'));

    }

    public function show($id) {

        $pcfr = Pcfr::find($id);

        $area_manager = User::where('position', 'area head')
            ->whereHas('branch_group', function($query) use ($pcfr) {
                $branch = auth()->user()->branch;
                $query->where('branch', 'LIKE', "%{$branch->name}%");
            })->get();

        return view('pages.pcfr.approver.show', compact('pcfr', 'area_manager'));

    }


    public function statusUpdate($id, Request $request){

        $pcfr = Pcfr::find($id);
        $pcfr->update(['status'  => $request->action]);

        return back()->with(['success'  => "{$pcfr->pcfr_no} was successfully submitted."]);

    }

    public function disapprove($id, Request $request) {

        $pcfr = Pcfr::find($id);
        $user = auth()->user();
        $disapprove = 'disapproved';

        if($user->getUserAssignTo() == 'ssc') {
            if($user->position == 'division head') {
                $disapprove = 'disapproved dh';
            } else {
                $disapprove = 'disapproved dept head';
            }
        } else {
            $disapprove = 'disapproved tl';
        }

        $pcfr->update([
            'status'            => $disapprove ,
            'remarks'           => $request->remarks ,
            'cancelled_by'      => auth()->user()->username ,
            'cancelled_date'    => \Carbon\Carbon::now() ,
        ]);

        return response()->json([
            'message'   => "{$pcfr->pcfr_no} was successfully Disapprove."
        ]);

    }


    public function approve($id, Request $request) {

        $pcfr = Pcfr::find($id);
        $user = auth()->user();

        if($user->getUserAssignTo() == 'ssc') {
                
            if( $user->position == 'department head') {

                $pcfr->update([
                    'tl_approved'       => 1 ,
                    'status'            => 'approved' ,
                    'approved_by'       => auth()->user()->username ,
                    'approved_date'     => \Carbon\Carbon::now() ,
                ]);

                return response()->json([
                    'need_code' =>  false ,
                    'message'   => "{$pcfr->pcfr_no} was successfully approved."
                ]);

            } else {

                $pcfr->update([
                    'dh_approved'       => 1 
                ]);

                return response()->json([
                    'need_code' =>  false ,
                    'message'   => "{$pcfr->pcfr_no} was successfully approved."
                ]);

            }

        } else {

            $pcfr->update([
                    'tl_approved'       => 1 ,
                    'status'            => 'approved' ,
                    'approved_by'       => auth()->user()->username ,
                    'approved_date'     => \Carbon\Carbon::now() ,
                ]);

            return response()->json([
                'need_code' =>  false ,
                'message'   => "{$pcfr->pcfr_no} was successfully approved."
            ]);

        }


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

        $pcvs = $pcv_new->with('user.branch')->get();
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
