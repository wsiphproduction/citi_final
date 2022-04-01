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

        if(request()->has('company')) {

            if(request()->name == 'petty cash expense') {
                //query is pcv

            } else {
                // query is pcfr

            }

        }

        return view('pages.report.index', compact('company', 'branch'));

    }


    public function search(Request $request) {

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
                    })->whereHas('pcfr', function($query){
                        $query->where('status', 'replenished');
                    });

                return 'pcv';
            } else {
                // query is pcfr
                return 'pcfr';
            }

        }

    }


}
