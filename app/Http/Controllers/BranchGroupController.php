<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BranchGroup;
use App\Models\Branch;

class BranchGroupController extends Controller
{


    public function index() {

        $branch_groups = BranchGroup::all();        

        return view('pages.branch-groups.index', compact('branch_groups'));

    }


    public function create() {

        $branch = Branch::where('status', 1)->get();
        
        return view('pages.branch-groups.create', compact('branch'));

    }


    public function store(Request $request) {

        $this->validate($request, [
            'size'      => 'required' ,
            'branch'    => 'required' ,
            'name'      => 'required'
        ]);

        $request['created_by'] = auth()->user()->username;

        BranchGroup::create($request->except('_token'));

        return redirect()->route('branch-group.index')->with('success', 'Branch Group Successfully Created.');

    }


    public function edit($id, Request $request) {

        $branch_group = BranchGroup::find($id);
        $branch = Branch::where('status', 1)->get();

        return view('pages.branch-groups.edit', compact('branch_group', 'branch'));

    }


    public function update($id, Request $request) {

        $this->validate($request, [
            'size'      => 'required' ,
            'branch'    => 'required' ,
            'name'      => 'required'
        ]);

        $request['updated_by'] = auth()->user()->username;

        $branch_group = BranchGroup::find($id);

        $branch_group->update($request->except('_token', '_method'));

        return redirect()->route('branch-group.index')->with('success', 'Branch Group Successfully Updated.');

    }


    public function delete($id) {

        $branch = Branch::find($id);
        $branch->delete();

        return redirect()->route('branch-group.index')->with('success', 'Branch Group Successfully Deleted.');

    }

}
