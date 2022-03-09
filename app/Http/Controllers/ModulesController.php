<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use Spatie\Permission\Models\Permission;

class ModulesController extends Controller
{


    public function index() {

        $modules = Module::all();

        return view('pages.module.index', compact('modules'));

    }

    public function create() {

        return view('pages.module.create');

    }

    public function store(Request $request) {

        Module::create($request->except('_token'));

        return redirect()->route('modules.index');

    }


    public function edit($id) {

        $module = Module::find($id);

        return view('pages.module.edit', compact('module'));

    }


    public function update($id, Request $request) {

        $module = Module::find($id);

        $module->update($request->except('_token','method'));

        return redirect()->route('modules.index');

    }

}
