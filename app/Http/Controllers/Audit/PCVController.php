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
  
        $pcvs = Pcv::where('status', 'approved')     
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.pcv.audit.index', compact('pcvs'));

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

        return view('pages.pcv.audit.show', compact('pcv', 'area_manager'));

    }

}
