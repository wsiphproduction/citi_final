<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobRequest;

class JobRequestController extends Controller
{


    public function search(Request $request) {

        $job_requests = JobRequest::where('request_no', $request->search)->first();

        return $job_requests;

    }

}
