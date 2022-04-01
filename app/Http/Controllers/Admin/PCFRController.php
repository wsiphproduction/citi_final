<?php

namespace App\Http\Controllers\Admin;

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
       
        $pcfr = Pcfr::orderBy('created_at', 'DESC')
            ->get();

        return view('pages.pcfr.admin.index', compact('pcfr'));

    }

    public function show($id) {

        $pcfr = Pcfr::find($id);

        return view('pages.pcfr.admin.show', compact('pcfr'));

    }

}
