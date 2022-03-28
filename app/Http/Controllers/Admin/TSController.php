<?php

namespace App\Http\Controllers\Admin;

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
        $temporary_slips = TemporarySlip::orderBy('created_at', 'DESC')
            ->get();

        return view('pages.ts.admin.index', compact('temporary_slips'));

    }

    public function show($id) {

        $ts = TemporarySlip::find($id);
                
        return view('pages.ts.admin.show', compact('ts'));

    }


}
