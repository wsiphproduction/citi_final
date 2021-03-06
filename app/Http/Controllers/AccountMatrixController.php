<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountMatrix;
use Illuminate\Validation\Rule;

class AccountMatrixController extends Controller
{


    public function index() {

        $matrix = AccountMatrix::all();

        return view('pages.account-matrix.index', compact('matrix'));

    }


    public function create() {

        $accounts = \App\Models\Account::getAccounts();

        return view('pages.account-matrix.create', compact('accounts'));

    }


    public function store(Request $request) {

        $this->validate($request, [

            'name'      => 'required' ,
            'number'    => 'required' ,
            'amount'    => Rule::requiredIf(!$request->has('regardless'))

        ]);

        $request['created_by'] = auth()->user()->username;

        AccountMatrix::create($request->except('_token'));

        return redirect()->route('account-matrix.index')->with('success', 'Account Matrix Successfully Created!');

    }


    public function edit($id) {

        $accounts = \App\Models\Account::getAccounts();
        $matrix = AccountMatrix::find($id);

        return view('pages.account-matrix.edit', compact('matrix', 'accounts'));

    }


    public function update($id, Request $request) {

        $this->validate($request, [

            'name'      => 'required' ,
            'number'    => 'required' ,
            'amount'    => Rule::requiredIf(!$request->has('regardless'))

        ]);

        $request['updated_by'] = auth()->user()->username;

        $matrix = AccountMatrix::find($id);
        $matrix->update($request->except('_token','_method'));

        return redirect()->route('account-matrix.index')->with('success', 'Account Matrix Successfully Updated!');

    }


}
