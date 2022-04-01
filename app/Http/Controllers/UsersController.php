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

        $users = User::where('status', 1)
            ->orderBy('created_at', 'DESC')->get();

        return view('pages.users.index', compact('users'));

    }


    public function inactive() {

        $users = User::onlyTrashed()
            ->orderBy('created_at', 'DESC')->get();

        return view('pages.users.inactive', compact('users'));

    }

    public function show($id) {

        $user = User::withTrashed()->find($id); 

        return view('pages.users.show', compact('user'));

    }


    public function create() {

        $roles = Role::all();
        $branch_groups = BranchGroup::all();
        $branch = Branch::where('status', 1)->get();
        return view('pages.users.create', compact('roles', 'branch_groups', 'branch'));

    }


    public function store(Request $request) {

        $this->validate($request, [

            'username'  => 'required|unique:users,username' ,
            'access'    => 'required' ,
            'position'  => 'required'

        ]);

        $existing_user = User::where('firstname', $request->firstname)
            ->where('lastname', $request->lastname)
            ->where('middlename', $request->middlename)
            ->first();

        if($existing_user) return redirect()->back()->with('danger', 'User already exists');

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
            'created_by'        => auth()->user()->username ,
            'store_type'         => $request->store_type
        ]);

        $user->assignRole($request->access);

        return redirect()->route('users.index')->with('success', 'User Successfully Created!');

    }


    public function edit($id) {

        $roles = Role::all();
        $branch_groups = BranchGroup::all();
        $user = User::withTrashed()->find($id);
        $branch = Branch::where('status', 1)->get();

        return view('pages.users.edit', compact('user', 'roles', 'branch_groups', 'branch'));

    }


    public function update($id, Request $request) {

        $user = User::withTrashed()->find($id);

        $this->validate($request, [

            'username'  => 'required|unique:users,username,'.$id ,
            'access'    => 'required' ,
            'position'  => 'required'

        ]);

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
            'status'            => $request->status ,
            'updated_at'        => \Carbon\Carbon::now() ,
            'updated_by'        => auth()->user()->username ,
            'store_type'        => $request->store_type
        ]);

        $user->assignRole($request->access);

        if($request->status == 0) {
            $user->delete();
        } else {
            $user->restore();
        }

        return redirect()->route('users.index')->with('success', 'User Successfully Updated!');
    }

}
