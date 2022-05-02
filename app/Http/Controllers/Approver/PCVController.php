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

        if($user->getUserAssignTo() != 'ssc') {
            $area_manager = User::where('position', 'area head')
                ->whereHas('branch_group', function($query) {
                    $branch = auth()->user()->branch;
                    $query->where('branch', 'LIKE', "%{$branch->name}%");
                })->get();
        } else {
            $area_manager = User::where('position', 'division head')
                ->where('assign_to', $user->assign_to)->get();
        }

        if( $user->getUserAssignTo() != 'ssc' ) {          
            $pcvs = Pcv::whereIn('status', ['submitted', 'confirmed', 'cancel','approved', 'cancelled']);
        } else {
            if($user->position == 'division head' ){ 
                $pcvs = Pcv::whereIn('status', ['approved','confirmed', 'cancelled']);
            } else {
                $pcvs = Pcv::whereIn('status', ['submitted', 'confirmed', 'cancel','approved', 'cancelled']);
            }
        }

        if( $user->getUserAssignTo() != 'ssc' ) {            
            $pcvs = $pcvs->whereHas('user', function(Builder $query) use ($user) {
                        $query->where('assign_to', $user->assign_to);
                    });
        } else {
            if($user->position == 'division head') {
                $pcvs = $pcvs->where('tl_approved',1);
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

        $pcvs = $pcvs->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.pcv.approver.index', compact('pcvs', 'area_manager'));

    }


    public function show($id) {

        $pcv = Pcv::find($id);

        $user = auth()->user();

        if($user->getUserAssignTo() != 'ssc') {
            $area_manager = User::where('position', 'area head')
                ->whereHas('branch_group', function($query) use ($pcv) {
                    $branch = auth()->user()->branch;
                    $query->where('branch', 'LIKE', "%{$branch->name}%");
                })->get();
        } else {
            $area_manager = User::where('position', 'division head')
                ->where('assign_to', $user->assign_to)->get();
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
            ->where('amount', $pcv->amount)
            ->where('status', 1)
            ->where('code', 1)
            ->orWhere(function($query) use ($pcv) {
                $query->where('name', $pcv->account_name)
                    ->where('amount', '<', $pcv->amount)
                    ->where('beyond', 1)
                    ->where('code', 1)
                    ->where('status', 1);
            })
            ->orWhere(function($query) use ($pcv) {
                $query->where('name', $pcv->account_name)
                    ->where('regardless', 1)
                    ->where('code', 1)
                    ->where('status', 1);
            })
            ->get();

        if(count($matrix)) {

            // if($user->getUserAssignTo() == 'ssc') {
                
            //     if( $user->position == 'department head') {

            //         $pcv->update([
            //                 'status'        => 'confirmed' ,
            //                 'tl_approved'   => 1
            //             ]);

            //         return response()->json([
            //             'status'        => 'confirmed' ,
            //             'need_code'     => false ,
            //             'message'   => "{$pcv->pcv_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
            //         ]);

            //     } else {

            //         $pcv->update([
            //             'status'        => 'confirmed' ,
            //             'dh_approved'   => 1
            //         ]);

            //         return response()->json([
            //             'status'        => 'confirmed' ,
            //             'need_code'     => true ,
            //             'message'   => "{$pcv->pcv_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
            //         ]);

            //     }

            // }

            $pcv->update([
                'status'        => 'confirmed' ,
                'tl_approved'   => 1
            ]);

            return response()->json([
                'status'        => 'confirmed' ,
                'need_code'     => true ,
                'pcv_id'        => $pcv->id ,
                'pcv_no'        => $pcv->pcv_no ,
                'message'       => "{$pcv->pcv_no} was successfully confirmed. The requested amount requires an Approval Code. Input Approval Code."
            ]);

        }

        // if( $user->position == 'division head') {

        //     $pcv->update([
        //         'dh_approved'       => 1 ,
        //         'status'            => 'approved'
        //     ]);


        // } else {

        $pcv->update([
            'tl_approved'       => 1 ,
            'status'            => 'approved' ,
            'approved_by'       => auth()->user()->firstname . ' ' . auth()->user()->lastname ,
            'approved_date'     => \Carbon\Carbon::now() ,
        ]);

        // }

        return response()->json([
            'need_code' =>  false ,
            'pcv_id'    => $pcv->id ,
            'pcv_no'    => $pcv->pcv_no ,
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
            'approved_by'       => auth()->user()->firstname . ' ' . auth()->user()->lastname ,
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
            $disapprove = 'disapproved dh';    
        } else {
            $disapprove = 'disapproved tl';
        }

        $pcv->update([
            'remarks'           => $request->remarks ,
            'status'            => $disapprove
        ]);

        return response()->json([
            'message'   => "{$pcv->pcv_no} was successfully Disapprove."
        ]);

    }


    public function approveCancel($id, Request $request) {

        $pcv = Pcv::find($id);

        $user = auth()->user();
        $disapprove = 'cancelled';

        $pcv->update([
            'status'            => $disapprove ,
            'cancelled_by'      => auth()->user()->firstname . ' ' . auth()->user()->lastname, ,
            'cancelled_date'    => \Carbon\Carbon::now()
        ]);

        return redirect()->route('approver.pcv.index')->with('success', "{$pcv->pcv_no} was successfully cancelled.");


    }

    public function disapproveCancel($id, Request $request) {

        $pcv = Pcv::find($id);

        $user = auth()->user();
        $disapprove = 'approved';

        $pcv->update([
            'status'            => $disapprove ,
            'remarks'           => $request->remarks ,
            'cancelled_by'      => auth()->user()->firstname . ' ' . auth()->user()->lastname, ,
            'cancelled_date'    => \Carbon\Carbon::now()
        ]);

        return redirect()->route('approver.pcv.index')->with('success', "{$pcv->pcv_no} request to cancel was disapproved.");

    }

}
