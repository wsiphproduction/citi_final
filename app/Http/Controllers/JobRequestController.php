<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobRequest;

class JobRequestController extends Controller
{


    public function search(Request $request) {

        $job_requests = JobRequest::where('request_no', $request->search)->distinct('brand')->get(['brand', 'request_no', 'project_name', 'project_type']);

        return $job_requests;

    }

}
