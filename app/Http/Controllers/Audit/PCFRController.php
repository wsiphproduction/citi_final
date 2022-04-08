<?php

namespace App\Http\Controllers\Audit;

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
       
        $pcfr = Pcfr::where('status', 'replenished');

        if(request()->has('branch') && request()->branch != '') {
            $pcfr = $pcfr->whereHas('user', function($query){
                $query->where('assign_to', request()->branch);
            });
        }
        
        $pcfr = $pcfr->orderBy('created_at', 'DESC')
            ->get();
        $branch = Branch::all();

        return view('pages.pcfr.audit.index', compact('pcfr','branch'));

    }

    public function show($id) {

        $pcfr = Pcfr::find($id);

        return view('pages.pcfr.audit.show', compact('pcfr'));

    }

}
