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
       
        $pcfr = Pcfr::where('status', 'replenished')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.pcfr.audit.index', compact('pcfr'));

    }

    public function show($id) {

        $pcfr = Pcfr::find($id);

        $area_manager = User::where('position', 'area head')
            ->whereHas('branch_group', function($query) use ($pcfr) {
                $branch = Branch::find($pcfr->user->assign_to);
                $query->where('branch', 'LIKE', "%{$branch->name}%");
            })->get();

        return view('pages.pcfr.audit.show', compact('pcfr', 'area_manager'));

    }

}
