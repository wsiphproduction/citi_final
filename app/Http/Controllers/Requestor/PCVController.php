<?php

namespace App\Http\Controllers\Requestor;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Pcv;
use App\Models\Attachment;
use App\Models\TemporarySlip;
use Illuminate\Validation\Rule;
use App\Models\AccountTransaction;
use App\Http\Controllers\Controller;
    
class PCVController extends Controller
{


    public function index() {

        $pcvs = Pcv::where('user_id', auth()->user()->id)->get();

        return view('pages.pcv.requestor.index', compact('pcvs'));

    }


    public function show($pcv) {

        $pcv = Pcv::where('pcv_no', $pcv)
            ->with(['attachments', 'account_transactions'])
            ->first();

        return view('pages.pcv.requestor.show', compact('pcv'));

    }

    public function copyPCV($pcv) {

        $pcv = Pcv::where('pcv_no', $pcv)
            ->with(['account_transactions', 'attachments'])
            ->first();

        return response()->json($pcv);

    }

    public function create() {

        $jsonString = file_get_contents(base_path('public/data/accounts.json'));
        $accounts = json_decode($jsonString, true);

        return view('pages.pcv.requestor.create', compact('accounts'));

    }


    public function store(Request $request) {

        $attachments = json_decode($request->pcv_attachments, true);
        $account_transactions = json_decode($request->pcv_accounts, true);
        $total_amount = 0;
        $user = auth()->user();

        $this->validate($request, [
            'ts_no'     => [ 
                Rule::requiredIf($request->has('withslip')),  
                Rule::exists('temporary_slips')
                    ->where(function($query) use ($request) {
                        return $query->where('ts_no', '=', $request->ts_no);
                    })
                ] ,
            'change'    => 'required|numeric'
        ]);

        // save pcv transaction
        $pcv_transaction = Pcv::create([
            'account_name'  => $request->account_name ,
            'change'        => $request->change ,
            'date_created'  => $request->date_created ,
            'pcv_no'        => Pcv::generatePCVNumber() ,
            'slip_no'       => $request->has('withslip') ? $request->ts_no : null ,
            'status'        => $request->pcv_action ,
            'user_id'       => auth()->user()->id
        ]);

        if( $request->has('withslip') ) {
            $ts = TemporarySlip::where('ts_no', $request->ts_no)->first();
            $total_amount = $total_amount + $ts->running_balance;
        }

        // add pcv reference to attachments
        // move attachment from temporary folder to original folder
        if(count($attachments)) {

            foreach( $attachments as $attachment ) {

                if($attachment['attachment'] == '') continue;

                Attachment::create([
                    'from'          => 'pcv' ,
                    'from_ref'      => $pcv_transaction->id , 
                    'type'          => $attachment['type'] ,
                    'ref'           => $attachment['ref'] ,
                    'date'          => \Carbon\Carbon::parse($attachment['date']) ,
                    'attachment'    => $attachment['attachment'] 
                ]);

                Storage::move("public/temp/{$user->id}/pcv/{$attachment['attachment']}", 
                    "public/pcv/{$pcv_transaction->pcv_no}/{$attachment['attachment']}");

                //Storage::deleteDirectory("public/temp/{$pcv_transaction->pcv_no}");

            }

        }

        // add pcv reference to account transactions
        if(count($account_transactions)) {

            foreach($account_transactions as $account_transaction) {

                AccountTransaction::create([
                    'name'          => $request->account_name ,
                    'details'       => $account_transaction , 
                    'pcv_id'        => $pcv_transaction->id ,
                    'status'        => 'approved' ,
                    'approval_code' => array_key_exists('code', $account_transaction) ? $account_transaction['code'] : null ,
                    'approved_by'   => array_key_exists('by', $account_transaction) ? $account_transaction['by'] : null ,
                    'approved_date' => array_key_exists('date', $account_transaction) ? $account_transaction['date'] : null ,
                    'remarks'       => array_key_exists('remarks', $account_transaction) ? $account_transaction['remarks'] : null 
                ]);

                if(array_key_exists("quantity", $account_transaction)) {
                    $total_amount = $total_amount + ($account_transaction ['amount'] * $account_transaction['quantity']);
                } else {
                    $total_amount = $total_amount + $account_transaction ['amount'];
                }

            }

        }

        $pcv_transaction->amount = $total_amount;
        $pcv_transaction->save();

        return redirect()->route('requestor.pcv.index')->with('success','PCV has been created!');

    }

    public function edit($pcv) {

        $pcv = Pcv::where('pcv_no', $pcv)
            ->with(['attachments', 'account_transactions'])
            ->first();

        return view('pages.pcv.edit', compact('pcv'));

    }

    public function update($pcv, Request $request) {

        $this->validate($request, [
            'ts_no'     => [ 
                Rule::requiredIf($request->has('withslip')),  
                Rule::exists('temporary_slips')
                    ->where(function($query) use ($request) {
                        return $query->where('ts_no', '=', $request->ts_no);
                    })
                ] ,
            'change'    => 'required|numeric'
        ]);

        $pcv = Pcv::where('pcv_no', $pcv)->first();

        $attachments = json_decode($request->pcv_attachments, true);
        $account_transactions = json_decode($request->pcv_accounts, true);
        $total_amount = 0;

        $pcv->update([
            'account_name'  => $request->account_name ,
            'change'        => $request->change ,
            'date_created'  => $request->date_created ,
            'slip_no'       => $request->has('withslip') ? $request->ts_no : null ,
            'status'        => $request->pcv_action ,
            'user_id'       => auth()->user()->id
        ]);


    }

    public function statusUpdate($id, Request $request){

        $pcv = Pcv::find($id);
        $pcv->update(['status'  => $request->action]);

        return back()->with(['success'  => "{$pcv->pcv_no} was successfully submitted."]);

    }


    public function receivedPcv($id, Request $request) {

        $pcv = Pcv::find($id);
        $pcv->update([
            'received_by'       => $request->name ,
            'received_date'     => $request->date
        ]);

        return response()->json([
            'message'   => "{$pcv->pcv_no} was successfully received."
        ]);

    }


    public function cancelled() {

        $pcv = Pcv::whereIn('status', ['cancelled', 'saved'])
                    ->with(['attachments', 'account_transactions'])
                    ->get();

        return response()->json($pcv);

    }


}
