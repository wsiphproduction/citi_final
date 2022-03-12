<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobRequest;

class JobRequestController extends Controller
{


    public function search(Request $request) {

        return JobRequest::where('request_no', $request->search)->first();

    }

}
