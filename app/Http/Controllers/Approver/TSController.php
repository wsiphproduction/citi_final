<?php

namespace App\Http\Controllers\Approver;

use File;
use Illuminate\Http\Request;
use App\Models\TemporarySlip;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AccountMatrix;
use App\Models\User;
use App\Models\Branch;

class TSController extends Controller
{


    public function index() {
        $user = auth()->user();
        $temporary_slips = TemporarySlip::whereIn('status', ['confirmed', 'submitted','approved'])
            ->whereHas('user', function(Builder $query) use($user) {
                if($user->getUserAssignTo() == 'ssc') {
                    if($user->position == 'division head') {
                        $query->where('assign_to', $user->assign_to);
                    } else {
                        $query->where('assign_to', $user->assign_to)
                            ->where('assign_name', $user->assign_name);
                    }
                } else {
                    $query->where('assign_to', $user->assign_to);
                }
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.ts.approver.index', compact('temporary_slips'));

    }

    public function show($id) {

        $ts = TemporarySlip::find($id);
        $user = auth()->user();

        if($user->getUserAssignTo() != 'ssc') {
            $area_manager = User::where('position', 'area head')
                ->whereHas('branch_group', function($query) use ($ts) {
                    $branch = Branch::find($ts->user->assign_to);
                    $query->where('branch', 'LIKE', "%{$branch->name}%");
                })->get();
        } else {
            $area_manager = User::where('position', 'division head')
                ->whereHas('branch_group', function($query) use ($ts) {
                    $branch = Branch::find($ts->user->assign_to);
                    $query->where('branch', 'LIKE', "%{$branch->name}%");
                })->get();
        }
        
        return view('pages.ts.approver.show', compact('ts', 'area_manager'));

    }


    public function search(Request $request) {

        $temporary_slips = TemporarySlip::where('ts_no', 'LIKE', "%{$request->ts_no}%")->get();

        return $temporary_slips;

    }


    public function approve($id, Request $request) {

        $ts = TemporarySlip::find($id);
        $user = auth()->user();

        $matrix = AccountMatrix::where('name', $ts->account_name)
            ->where('amount', '=', $ts->amount)
            ->where('status', 1)
            ->orWhere(function($query) use ($ts) {
                $query->where('name', $ts->account_name)
                    ->where('amount', '<', $ts->amount)
                    ->where('beyond', 1)
                    ->where('status', 1);
            })
            ->orWhere(function($query) use ($ts) {
                $query->where('name', $ts->account_name)
                    ->where('regardless', 1)
                    ->where('status', 1);
            })
            ->get();

        if(count($matrix)) {

            if($user->getUserAssignTo() == 'ssc') {

                if( $user->position == 'department head') {
                    $ts->update([
                        'status'        => 'confirmed' ,
                        'tl_approved'   => 1
                    ]);

                    return response()->json([
                        'status'        => 'confirmed' ,
                        'need_code'     => false ,
                        'message'       => "{$ts->ts_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
                    ]);

                } else {
                    $ts->update([
                        'status'        => 'confirmed' ,
                        'dh_approved'   => 1
                    ]);

                    return response()->json([
                        'status'        => 'confirmed' ,
                        'need_code'     => true ,
                        'message'       => "{$ts->ts_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
                    ]);

                }
   
            }

            $ts->update([
                'status'        => 'confirmed' ,
                'tl_approved'   => 1
            ]);

            return response()->json([
                'status'    => 'confirmed' ,
                'need_code' => true ,
                'message'   => "{$ts->ts_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
            ]);

        }

        $ts->update([
            'tl_approved'       => 1 ,
            'status'            => 'approved' ,
            'approved_by'       => auth()->user()->username ,
            'approved_date'     => \Carbon\Carbon::now() ,
        ]);
                    
        return response()->json([
            'need_code' =>  false ,
            'message'   => "{$ts->ts_no} was successfully Approved."
        ]);

    }


    public function approveWithCode($id, Request $request) {

        $ts = TemporarySlip::find($id);
        $ts->update([
            'approval_code'     => $request->code ,
            'approver_name'     => $request->name ,
            'remarks'           => $request->remarks ,
            'status'            => 'approved' ,
            'approved_by'       => auth()->user()->username ,
            'approved_date'     => \Carbon\Carbon::now()
        ]);

        return response()->json([
            'message'   => "{$ts->ts_no} was successfully Approved."
        ]);
        
    }   


    public function disapprove($id, Request $request) {

        $ts = TemporarySlip::find($id);
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

        $ts->update([
            'status' => $disapprove ,
            'cancelled_by'      => auth()->user()->username ,
            'cancelled_date'    => \Carbon\Carbon::now()
        ]);

        return response()->json([
            'message'   => "{$ts->ts_no} was successfully Disapprove."
        ]);

    }

    public function print($id) {

        $ts = TemporarySlip::find($id);

        return view('pages.ts.approver.print', compact('ts'));

    }

}
