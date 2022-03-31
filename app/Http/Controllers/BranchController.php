<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\BranchDepartment;

class BranchController extends Controller
{


    public function index() {

        $branch = Branch::orderBy('created_at', 'DESC')->get();

        return view('pages.branch.index', compact('branch'));

    }


    public function create() {

        return view('pages.branch.create');

    }


    public function show($id) {

        $branch = Branch::find($id);

        return view('pages.branch.show', compact('branch'));

    }


    public function store(Request $request) {

        $this->validate($request, [
            'name'              => 'required|unique:temp_branch,name' ,
            'budget'            => 'required' ,
            'company_name'      => 'required'
        ]);

        $request['created_by'] = auth()->user()->username;

        Branch::create($request->except('_token'));

        return redirect()->route('branch.index')->with('success', 'Branch Successfully Created.');

    }


    public function edit($id, Request $request) {

        $branch = Branch::find($id);

        return view('pages.branch.edit', compact('branch'));

    }


    public function update($id, Request $request) {

        $this->validate($request, [
            'name'              => 'required|unique:temp_branch,name,'.$id ,
            'budget'            => 'required' ,
            'company_name'      => 'required'
        ]);

        $request['updated_by'] = auth()->user()->username;

        $branch = Branch::find($id);

        $branch->update($request->except('_token', '_method'));

        return redirect()->route('branch.index')->with('success', 'Branch Successfully Updated.');

    }


    public function delete($id) {

        $branch = Branch::find($id);
        $branch->delete();

        return redirect()->route('branch.index')->with('success', 'Branch Successfully Deleted.');

    }


    public function list(Request $request) {

        // API CALL

        if($request->type == 'head office') {
            $departments = \DB::table('api_branch')
                ->where('STORE_TYPE', $request->type)
                ->distinct('DEPARTMENTS')
                ->get(['DEPARTMENTS', 'STORE_CODE']);
        } else {
            $departments = \DB::table('api_branch')
                ->distinct('STORE_CODE')
                ->where('STORE_TYPE', $request->type)
                ->get(['OPERATING_UNIT_NAME', 'STORE_CODE', 'STORE_TYPE', 'BRANCH_SIZE', 'ASSIGNED_STORE']);
        }
        //BranchDepartment::where('branch_id', $request->branch)->get();

        return $departments;

    }


    public function sync() {

        // $ch = curl_init();
        // $headers = array(
        //     'Accept: application/json',
        //     'Content-Type: application/json',
        // );
        // curl_setopt($ch, CURLOPT_URL, route('api.branch'));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_HEADER, 0);

        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // $result = json_decode($response);

        // CALL API 

        $api_branch = \DB::table('api_branch')->distinct('STORE_CODE')->get(['OPERATING_UNIT_NAME', 'STORE_CODE', 'STORE_TYPE', 'BRANCH_SIZE', 'ASSIGNED_STORE']);

        foreach( $api_branch as $branch ) {

            $temp_branch = Branch::where('name', $branch->OPERATING_UNIT_NAME . ' - ' . $branch->ASSIGNED_STORE)
                ->where('store_id', $branch->STORE_CODE)
                ->where('company_name', $branch->OPERATING_UNIT_NAME)
                ->where('store_size', $branch->BRANCH_SIZE)
                ->where('store_type', $branch->STORE_TYPE)
                ->first();

            if(!$temp_branch) {

                Branch::create([
                    'name'          => $branch->OPERATING_UNIT_NAME . ' - ' . $branch->ASSIGNED_STORE ,
                    'store_id'      => $branch->STORE_CODE ,
                    'company_name'  => $branch->OPERATING_UNIT_NAME ,
                    'store_size'    => $branch->BRANCH_SIZE ,
                    'store_type'    => $branch->STORE_TYPE , 
                    'status'        => 1 ,
                    'created_by'    => auth()->user()->username
                ]);

            }

        }


    }

}
