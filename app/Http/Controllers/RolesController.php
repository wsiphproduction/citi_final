<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index() {

        $roles = Role::all();
        return view('pages.roles.index', compact('roles'));

    }


    public function rolePermissions(Request $request) {

        $role = Role::findById($request->role_id);
        
        return $role->permissions;

    }


    public function create() {

        return view('pages.roles.create');

    }


    public function store(Request $request) {

        $role = Role::create($request->except('_token'));

        return redirect()->route('roles.index');

    }


    public function edit($id) {

        $role = Role::find($id);

        return view('pages.roles.edit', compact('role'));

    }


    public function update($id, Request $request) {

        $role = Role::find($id);
        $role->update($request->except('_token', '_method'));

        return redirect()->route('roles.index');

    }

}
