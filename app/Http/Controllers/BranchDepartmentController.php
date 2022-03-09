<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchDeparment;

class BranchDepartmentController extends Controller
{

    public function show($id) {

        $branch_department = BranchDeparment::find($id)

    }

}
