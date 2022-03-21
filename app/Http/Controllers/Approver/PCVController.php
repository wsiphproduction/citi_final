<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Models\Pcv;
use App\Models\User;
use App\Models\Branch;
use App\Models\Attachment;
use App\Models\TemporarySlip;
use App\Models\AccountMatrix;
use Illuminate\Validation\Rule;
use App\Models\AccountTransaction;

class PCVController extends Controller
{


    public function index() {

        $user = auth()->user();

        if( $user->getUserAssignTo() != 'ssc' ) {          
            $pcvs = Pcv::whereIn('status', ['submitted', 'confirmed']);
        } else {
            if($user->position == 'division head' ){ 
                $pcvs = Pcv::whereIn('status', ['approved','confirmed']);
            } else {
                $pcvs = Pcv::whereIn('status', ['submitted', 'confirmed']);
            }
        }

        if( $user->getUserAssignTo() != 'ssc' ) {            
            $pcvs = $pcvs->whereNull('tl_approved')
                ->whereHas('user', function(Builder $query) use ($user) {
                    $query->where('assign_to', $user->assign_to);
                });
        } else {
            if($user->position == 'division head') {
                $pcvs = $pcvs->where('tl_approved',1);
            } else {
                $pcvs = $pcvs->whereNull('tl_approved');
            }

            $pcvs = $pcvs->whereHas('user', function(Builder $query) use ($user) {
                if($user->position == 'division head' ) {
                    $query->where('assign_to', $user->assign_to);                        
                } else {
                    $query->where('assign_to', $user->assign_to)
                        ->where('assign_name', $user->assign_name);
                        
                }
            });

        }

        $pcvs = $pcvs->doesntHave('pcfr')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.pcv.approver.index', compact('pcvs'));

    }


    public function show($id) {

        $pcv = Pcv::find($id);

        $user = auth()->user();

        if($user->getUserAssignTo() != 'ssc') {
            $area_manager = User::where('position', 'area head')
                ->whereHas('branch_group', function($query) use ($pcv) {
                    $branch = Branch::find($pcv->user->assign_to);
                    $query->where('branch', 'LIKE', "%{$branch->name}%");
                })->get();
        } else {
            $area_manager = User::where('position', 'division head')
                ->whereHas('branch_group', function($query) use ($pcv) {
                    $branch = Branch::find($pcv->user->assign_to);
                    $query->where('branch', 'LIKE', "%{$branch->name}%");
                })->get();
        }

        return view('pages.pcv.approver.show', compact('pcv', 'area_manager'));

    }

    public function cancelled() {

        $pcv = Pcv::whereIn('status', ['cancelled', 'saved'])
                    ->with(['attachments', 'account_transactions'])
                    ->get();

        return response()->json($pcv);

    }


    public function approve($id, Request $request) {

        $pcv = Pcv::find($id);
        $user = auth()->user();

        $matrix = AccountMatrix::where('name', $pcv->account_name)
            ->where('amount', '=', $pcv->amount)
            ->where('status', 1)
            ->orWhere(function($query) use ($pcv) {
                $query->where('name', $pcv->account_name)
                    ->where('amount', '<', $pcv->amount)
                    ->where('beyond', 1)
                    ->where('status', 1);
            })
            ->orWhere(function($query) use ($pcv) {
                $query->where('name', $pcv->account_name)
                    ->where('regardless', 1)
                    ->where('status', 1);
            })
            ->get();

        if(count($matrix)) {

            if($user->getUserAssignTo() == 'ssc') {
                
                if( $user->position == 'department head') {

                    $pcv->update([
                            'status'        => 'confirmed' ,
                            'tl_approved'   => 1
                        ]);

                    return response()->json([
                        'status'        => 'confirmed' ,
                        'need_code'     => false ,
                        'message'   => "{$pcv->pcv_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
                    ]);

                } else {

                    $pcv->update([
                        'status'        => 'confirmed' ,
                        'dh_approved'   => 1
                    ]);

                    return response()->json([
                        'status'        => 'confirmed' ,
                        'need_code'     => true ,
                        'message'   => "{$pcv->pcv_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
                    ]);

                }

            }

            $pcv->update([
                'status'        => 'confirmed' ,
                'tl_approved'   => 1
            ]);

            return response()->json([
                'status'        => 'confirmed' ,
                'need_code'     => true ,
                'message'   => "{$pcv->pcv_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
            ]);

        }

        if( $user->position == 'division head') {

            $pcv->update([
                'dh_approved'       => 1 ,
                'status'            => 'approved' ,
                'approved_by'       => auth()->user()->username ,
                'approved_date'     => \Carbon\Carbon::now() ,
            ]);


        } else {

            $pcv->update([
                'tl_approved'       => 1 ,
                'status'            => 'approved' ,
                'approved_by'       => auth()->user()->username ,
                'approved_date'     => \Carbon\Carbon::now() ,
            ]);

        }

        return response()->json([
            'need_code' =>  false ,
            'message'   => "{$pcv->pcv_no} was successfully approved."
        ]);

    }


    public function approveWithCode($id, Request $request) {

        $pcv = Pcv::find($id);
        $pcv->update([
            'approval_code'     => $request->code ,
            'approver_name'     => $request->name ,
            'remarks'           => $request->remarks ,
            'status'            => 'approved' ,
            'approved_by'       => auth()->user()->username ,
            'approved_date'     => \Carbon\Carbon::now()
        ]);

        return response()->json([
            'message'   => "{$pcv->pcv_no} was successfully Approved."
        ]);
        
    }   


    public function disapprove($id, Request $request) {

        $pcv = Pcv::find($id);

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

        $pcv->update([
            'status'            => $disapprove ,
            'cancelled_by'      => auth()->user()->username ,
            'cancelled_date'    => \Carbon\Carbon::now()
        ]);

        return response()->json([
            'message'   => "{$pcv->pcv_no} was successfully Disapprove."
        ]);

    }


}
