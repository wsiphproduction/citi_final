<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\Attachment;
use Illuminate\Validation\Rule;

class VendorsController extends Controller
{


    public function index() {

        if( auth()->user()->position == 'administrator' || auth()->user()->position == 'Administrator') {

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


    public function inactive() {

        if( auth()->user()->position == 'administrator' || auth()->user()->position == 'Administrator') {

            $vendors = Vendor::where('status', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

        } else { 

            $vendors = Vendor::where('branch_id', auth()->user()->assign_to)
                ->orWhereNull('branch_id')
                ->where('status', 0) 
                ->orderBy('created_at', 'DESC')           
                ->get();

        }

        return view('pages.vendors.inactive', compact('vendors'));

    }


    public function create() {

        $branch = Branch::where('status', 1)
            ->get();

        return view('pages.vendors.create', compact('branch'));

    }


    public function show($id) {

        $vendor = Vendor::find($id);

        return view('pages.vendors.show', compact('vendor'));

    }


    public function store(Request $request) {

        if(auth()->user()->position == 'administrator' || auth()->user()->position == 'Administrator'){
            $this->validate($request, [
                'name'              => 'required' ,
                'address'           => 'required' ,
                'tin'               => 'max:50' ,
                'contact_number'    => 'required|max:50|numeric' ,
                'branch_id'         => 'required'
            ]);
        } else {
            $this->validate($request, [
                'name'              => 'required' ,
                'address'           => 'required' ,
                'tin'               => 'max:50' ,
                'contact_number'    => 'required|max:50|numeric' ,                
            ]);

            $request['branch_id']  = auth()->user()->assign_to;            
        }

        $paths = [];
        $request['created_by']  = auth()->user()->username;

        $vendor = Vendor::create($request->except('_token', 'attachments'));

        if( $request->hasFile('attachments') ) {            

            foreach($request->attachments as $attachment) {
                
                $filename = str_replace(" ", "_", $request->name) . '-' . time() . '-' . $attachment->getClientOriginalName();
                Storage::putFileAs("public/vendors/{$vendor->id}/attachments", $attachment, $filename);

                Attachment::create([
                    'from'          => 'vendor' ,
                    'from_ref'      => $vendor->id ,
                    'type'          => 'supporting details' ,
                    'ref'           => 'vendor' ,
                    'attachment'    => $filename
                ]);

            }

        }

        return redirect()->route('vendors.index')->with('success', 'Vendor has been added Successfully!!');

    }


    public function edit($id) {

        $vendor = Vendor::find($id);
        $branch = Branch::where('status', 1)
            ->get();

        return view('pages.vendors.edit', compact('vendor', 'branch'));

    }

    public function update($id, Request $request) {

        if(auth()->user()->position == 'administrator' || auth()->user()->position == 'Administrator'){
            $this->validate($request, [
                'name'              => 'required' ,
                'address'           => 'required' ,
                'tin'               => 'max:50' ,
                'contact_number'    => 'required|numeric|max:50' ,
                'branch_id'         => 'required'
            ]);
        } else {
            $this->validate($request, [
                'name'              => 'required' ,
                'address'           => 'required' ,
                'tin'               => 'max:50' ,
                'contact_number'    => 'required|numeric|max:50' ,                
            ]);

            $request['branch_id']  = auth()->user()->assign_to;            
        }

        $paths = [];
        $request['updated_by']  = auth()->user()->username;

        $vendor = Vendor::find($id);
        $vendor->update($request->except('_token', '_method', 'attachments'));

        if( $request->hasFile('attachments') ) {            

            foreach($request->attachments as $attachment) {
                
                $filename = str_replace(" ", "_", $request->name) . '-' . time() . '-' . $attachment->getClientOriginalName();
                Storage::putFileAs("public/vendors/{$vendor->id}/attachments", $attachment, $filename);

                Attachment::create([
                    'from'          => 'vendor' ,
                    'from_ref'      => $vendor->id ,
                    'type'          => 'supporting details' ,
                    'ref'           => 'vendor' ,
                    'attachment'    => $filename
                ]);

            }

        }

        return redirect()->route('vendors.index')->with('success', 'Vendor has been updated Successfully!!');

    }


    public function delete($id) {
        
        $attachment = Attachment::find($id);
        $attachment->delete();

        return response()->json($attachment);

    }


    public function search() {

        $search = request()->search;

        $existing_branch = Vendor::where('status', 1)
            ->where('branch_id', auth()->user()->assign_to)
            ->where('name', 'LIKE', "%{$search}%")
            ->get();

        return $existing_branch;

    }


}
