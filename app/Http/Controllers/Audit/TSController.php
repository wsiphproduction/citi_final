<?php

namespace App\Http\Controllers\Audit;

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
        
        $temporary_slips = TemporarySlip::where('status', 'approved');            
        
        if(request()->has('branch') && request()->branch != '') {
            $temporary_slips = $temporary_slips->whereHas('user', function($query){
                $query->where('assign_to', request()->branch);
            });
        }

        $temporary_slips = $temporary_slips->orderBy('created_at', 'DESC')
            ->get();

        $branch = Branch::all();//get('store_size');

        return view('pages.ts.audit.index', compact('temporary_slips', 'branch'));

    }

    public function show($id) {

        $ts = TemporarySlip::find($id);
        $user = auth()->user();
        
        return view('pages.ts.audit.show', compact('ts'));

    }


}
