<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index() {

        $roles = Role::orderBy('created_at', 'DESC')->get();
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

        $this->validate($request, [
            'name'  => 'required|unique:roles,name|max:50'
        ]);

        $role = Role::create($request->except('_token'));

        return redirect()->route('roles.index')->with('success', 'Role Successfully Created');

    }


    public function edit($id) {

        $role = Role::find($id);

        return view('pages.roles.edit', compact('role'));

    }


    public function update($id, Request $request) {

        $this->validate($request, [
            'name'  => 'required||min:50|unique:roles,name,' . $id
        ]);

        $role = Role::find($id);
        $role->update($request->except('_token', '_method'));

        return redirect()->route('roles.index')->with('success', 'Role Successfully Updated');

    }

}
