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

        if( $user->getUserAssignTo() != 'ssc' ) {          
            $pcfr = Pcfr::where('status', 'approved')
                ->where('tl_approved', 1);
        } else {
            if($user->position == 'division head' ){ 
                $pcfr = Pcfr::where('status', 'approved')
                    ->where('tl_approved', 1);
            } else {
                $pcfr = Pcfr::where('status', 'approved')
                    ->where('tl_approved', 1);
            }
        }

        if( $user->getUserAssignTo() != 'ssc' ) {            
            $pcfr = $pcfr->whereHas('user', function(Builder $query) use ($user) {
                    $query->where('assign_to', $user->assign_to);
                });
        } else {

            $pcfr = $pcfr->whereHas('user', function(Builder $query) use ($user) {
                if($user->position == 'division head' ) {
                    $query->where('assign_to', $user->assign_to);
                } else {
                    $query->where('assign_to', $user->assign_to)
                        ->where('assign_name', $user->assign_name);
                }
            });

        }

        $pcfr = $pcfr->get();

        return view('pages.pcfr.payable.index', compact('pcfr'));

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

        return redirect()->back()->with('success', "{$pcv->pcv_no} successfully removed");

    }

    public function statusUpdate($id, Request $request){

        $pcfr = Pcfr::find($id);
        $pcfr->update(['status'  => $request->action]);

        return back()->with(['success'  => "{$pcfr->pcfr_no} was successfully submitted."]);

    }
   
}
