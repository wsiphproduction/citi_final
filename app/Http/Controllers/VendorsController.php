<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorsController extends Controller
{


    public function index() {

        if( auth()->user()->position == 'administrator') {

            $vendors = Vendor::where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->get();

        } else { 

            $vendors = Vendor::where('branch_id', auth()->user()->assign_to)
                ->orWhereNull('branch_id')
                ->where('status', 1) 
                ->orderBy('created_at', 'DESC')           
                ->get();

        }

        return view('pages.vendors.index', compact('vendors'));

    }


    public function create() {

        return view('pages.vendors.create');

    }


    public function show($id) {

        $vendor = Vendor::find($id);

        return view('pages.vendors.show', compact('vendor'));

    }


    public function store(Request $request) {

        $this->validate($request, [
            'name'              => 'required' ,
            'address'           => 'required' ,
            'tin'               => 'required' ,
            'contact_number'    => 'required' ,
        ]);

        $paths = [];

        $request['attachment']  = $paths;
        $request['created_by']  = auth()->user()->username;
        $request['branch_id']   = is_null(auth()->user()->assign_to) ? null : auth()->user()->assign_to;

        $vendor = Vendor::create($request->except('_token', 'attachments'));

        if( $request->hasFile('attachments') ) {            

            foreach($request->attachments as $attachment) {
                
                $filename = str_replace(" ", "_", $request->name) . '-' . time() . '-' . $attachment->getClientOriginalName();

                Storage::putFileAs("public/vendors/{$vendor->id}/attachments", $attachment, $filename);

                $paths[] = $filename;

            }

        }

        $vendor->attachment = $paths;
        $vendor->save();

        return redirect()->route('vendors.index')->with('success', 'Vendor has been added successfully!!');

    }


    public function edit($id) {



    }

    public function update($id, Request $request) {



    }


}
