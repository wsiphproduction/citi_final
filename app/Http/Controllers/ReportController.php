<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Pcv;
use App\Models\Pcfr;

class ReportController extends Controller
{

    public function index() {

        $company = Branch::distinct('company_name')->get(['company_name'])->pluck('company_name');
        $branch  = Branch::distinct('name')->get(['name'])->pluck('name');

        return view('pages.report.index', compact('company', 'branch'));

    }


    public function search(Request $request) {

        $from = $request->from;
        $to   = $request->to;

        if(request()->has('company')) {

            $companies = explode(',', $request->company);
            $branches = explode(',', $request->branch);

            $branch = Branch::whereIn('company_name', $companies)
                ->whereIn('name', $branches)
                ->pluck('store_id');

            if(request()->name == 'petty cash expense') {
                //query is pcv
                $pcv = Pcv::where('status', 'approved')
                    ->whereHas('user', function($query) use ($branch) {
                        $query->whereIn('assign_to', $branch);
                    })
                    ->whereDate('date_created', '>=', request()->from)
                    ->whereDate('date_created', '<=', request()->to)
                    ->groupBy('account_name')
                    ->select(\DB::raw("SUM(`amount`) AS `amount`"), 'account_name')
                    ->get();

                $request = request()->all();

                return view('pages.report.expenses-report', compact('pcv', 'request', 'from', 'to'));
            } else {

                $pcfr = Pcfr::where('status', 'approved')
                    ->whereHas('user', function($query) use ($branch) {
                        $query->whereIn('assign_to', $branch);
                    })
                    ->whereDate('from', '>=', request()->from)
                    ->whereDate('from', '<=', request()->to)
                    ->whereDate('to', '>=', request()->from)
                    ->whereDate('to', '<=', request()->to)
                    ->get();
                
                $request_type = request()->name;
                $request = request()->all();

                return response()->json($pcfr);
                return view('pages.report.pcfr-report', compact('pcfr', 'request_type', 'request', 'from', 'to'));
            }

        }

    }


    public function search1(Request $request) {

        $pcfr = Pcfr::where('pcfr_no', request()->pcfr_no)->first();
        $from = $request->from;
        $to   = $request->to;
            
        $request_type = request()->name;
        $request = request()->all();

        return view('pages.report.pcfr-report', compact('pcfr', 'request_type', 'request', 'from', 'to'));

    }

}
