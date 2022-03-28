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
        $temporary_slips = TemporarySlip::where('status', 'approved')            
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.ts.audit.index', compact('temporary_slips'));

    }

    public function show($id) {

        $ts = TemporarySlip::find($id);
        $user = auth()->user();

        if($user->getUserAssignTo() != 'ssc') {
            $area_manager = User::where('position', 'area head')
                ->whereHas('branch_group', function($query) use ($ts) {
                    $branch = Branch::find($ts->user->assign_to);
                    $query->where('branch', 'LIKE', "%{$branch->name}%");
                })->get();
        } else {
            $area_manager = User::where('position', 'division head')
                ->where('assign_to', $ts->user->assign_to)->get();
        }
        
        return view('pages.ts.audit.show', compact('ts', 'area_manager'));

    }


}
