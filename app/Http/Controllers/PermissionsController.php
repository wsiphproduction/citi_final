<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Arr;

class PermissionsController extends Controller
{


    public function index() {

        $permissions = Permission::all();
        $roles = Role::all();
        $modules = Module::all();
        $actions = array_unique(Arr::flatten($modules->pluck('actions')));

        return view('pages.permissions.index', compact('permissions', 'roles', 'modules', 'actions'));

    }


    public function create() {

        return view('pages.permissions.create');

    }


    public function store(Request $request) {

        $role = Role::findById($request->role_id);
        
        if($request->has('actions') && count($request->actions)) {
            foreach( \Arr::flatten($request->actions) as $action ) {

                Permission::findOrCreate($action);

            }
        }

        $role->syncPermissions($request->actions);

        return response()->json(['success'  => 'yeppeee']);

    }


    public function getRolePermissions() {

        $role = Role::findById($request->role_id);

    }

}
