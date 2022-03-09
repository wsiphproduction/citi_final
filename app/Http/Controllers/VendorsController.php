<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorsController extends Controller
{


    public function index() {

        $vendors = Vendor::all();

        return view('pages.vendors.index', compact('vendors'));

    }


    public function create() {

        return view('pages.vendors.create');

    }


    public function store(Request $request) {

        $this->validate($request, [
            'name'              => 'required' ,
            'address'           => 'required' ,
            'tin'               => 'required' ,
            'contact_number'    => 'required' ,
        ]);

        $paths = [];

        if( $request->hasFile('attachments') ) {            

            foreach($request->attachments as $attachment) {
                
                $filename = str_replace(" ", "_", $request->name) . '-' . time() . '-' . $attachment->getClientOriginalName();

                Storage::putFileAs('public/vendors/attachments', $attachment, $filename);

                $paths[] = $filename;

            }

        }

        $request['attachment']  = $paths;
        $request['created_by']  = auth()->user()->username;

        Vendor::create($request->except('_token', 'attachments'));

        return redirect()->route('vendors.index')->with('success', 'Vendor has been added successfully!!');

    }


    public function edit($id) {



    }

    public function update($id, Request $request) {



    }


}
