<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\BranchGroup;
use App\Models\Branch;

class UsersController extends Controller
{


    public function index() {

        $users = User::all();

        return view('pages.users.index', compact('users'));

    }


    public function create() {

        $roles = Role::all();
        $branch_groups = BranchGroup::all();
        $branch = Branch::where('status', 1)->get();
        return view('pages.users.create', compact('roles', 'branch_groups', 'branch'));

    }


    public function store(Request $request) {

        $user = User::create([
            'firstname'         => $request->firstname ,
            'lastname'          => $request->lastname , 
            'middlename'        => $request->middlename ,
            'branch_group_id'   => $request->branch_group_id ,
            'username'          => $request->username ,
            'password'          => \Hash::make($request->password) ,
            'assign_to'         => $request->assign_to ,
            'assign_name'       => $request->assign_name ,
            'position'          => $request->position ,
            'created_by'        => auth()->user()->username
        ]);

        $user->assignRole($request->access);

        return redirect()->route('users.index')->with('success', 'User successfully created!');

    }


    public function edit($id) {

        $roles = Role::all();
        $branch_groups = BranchGroup::all();
        $user = User::find($id);
        $branch = Branch::where('status', 1)->get();

        return view('pages.users.edit', compact('user', 'roles', 'branch_groups', 'branch'));

    }


    public function update($id, Request $request) {

        $user = User::find($id);

        foreach($user->getRoleNames() as $role) {
            $user->removeRole($role);
        }

        $user->update([
            'firstname'         => $request->firstname ,
            'lastname'          => $request->lastname , 
            'middlename'        => $request->middlename ,
            'branch_group_id'   => $request->branch_group_id ,
            'username'          => $request->username ,
            'assign_to'         => $request->assign_to ,
            'assign_name'       => $request->assign_name ,
            'position'          => $request->position ,
            'created_by'        => auth()->user()->username
        ]);

        $user->assignRole($request->access);

        return redirect()->route('users.index')->with('success', 'User successfully updated!');
    }

}
