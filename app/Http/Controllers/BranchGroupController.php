<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BranchGroup;
use App\Models\Branch;

class BranchGroupController extends Controller
{


    public function index() {

        $branch_groups = BranchGroup::orderBy('created_at', 'DESC')->get();        

        return view('pages.branch-groups.index', compact('branch_groups'));

    }


    public function create() {

        $branch = Branch::where('status', 1)->get();
        $branch_sizes = \DB::table('api_branch')->distinct('BRANCH_SIZE')->get(['BRANCH_SIZE']);

        return view('pages.branch-groups.create', compact('branch', 'branch_sizes'));

    }


    public function show($id) {

        $branch_group = BranchGroup::find($id);

        return view('pages.branch-groups.show', compact('branch_group'));

    }


    public function store(Request $request) {

        $this->validate($request, [
            'size'      => 'required' ,
            'branch'    => 'required' ,
            'name'      => 'required|unique:branch_groups,name'
        ]);

        $request['created_by'] = auth()->user()->username;

        BranchGroup::create($request->except('_token'));

        return redirect()->route('branch-group.index')->with('success', 'Branch Group Created Successfully .');

    }


    public function edit($id, Request $request) {

        $branch_group = BranchGroup::find($id);
        $branch = Branch::where('status', 1)->get();
        $branch_sizes = \DB::table('api_branch')->distinct('BRANCH_SIZE')->get(['BRANCH_SIZE']);

        return view('pages.branch-groups.edit', compact('branch_group', 'branch', 'branch_sizes'));

    }


    public function update($id, Request $request) {

        $this->validate($request, [
            'size'      => 'required' ,
            'branch'    => 'required' ,
            'name'      => 'required|unique:branch_groups,name,'.$id
        ]);

        $request['updated_by'] = auth()->user()->username;

        $branch_group = BranchGroup::find($id);

        $branch_group->update($request->except('_token', '_method'));

        return redirect()->route('branch-group.index')->with('success', 'Branch Group Updated Successfully .');

    }


    public function delete($id) {

        $branch = Branch::find($id);
        $branch->delete();

        return redirect()->route('branch-group.index')->with('success', 'Branch Group Deleted Successfully.');

    }

}
