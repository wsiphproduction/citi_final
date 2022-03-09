<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\BranchDepartment;

class BranchController extends Controller
{


    public function index() {

        $branch = Branch::all();

        return view('pages.branch.index', compact('branch'));

    }


    public function create() {

        return view('pages.branch.create');

    }


    public function store(Request $request) {

        $this->validate($request, [
            'name'      => 'required' ,
            'budget'    => 'required'
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
            'name'      => 'required' ,
            'budget'    => 'required'
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

        $departments = BranchDepartment::where('branch_id', $request->branch)->get();

        return $departments;

    }

}
