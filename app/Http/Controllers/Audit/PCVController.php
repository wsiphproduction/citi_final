<?php

namespace App\Http\Controllers\Audit;

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
  
        $pcvs = Pcv::where('status', 'approved');

        if(request()->has('branch') && request()->branch != '') {
            $pcvs = $pcvs->whereHas('user', function($query){
                $query->where('assign_to', request()->branch);
            });
        }

        $pcvs = $pcvs->orderBy('created_at', 'DESC')
            ->get();

        $branch = Branch::all();

        return view('pages.pcv.audit.index', compact('pcvs', 'branch'));

    }

    public function show($id) {

        $pcv = Pcv::find($id);

        return view('pages.pcv.audit.show', compact('pcv'));

    }

}
