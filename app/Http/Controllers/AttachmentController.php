<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{


    public function upload(Request $request) {

        if($request->hasFile('file')) {

            $file = $request->file('file');
            $filename = $request->from.'_'. date('d-m-Y-H-i') .'_'.$file->getClientOriginalName();
            $user = auth()->user();

            Storage::putFileAs("public/temp/{$user->id}/{$request->from}", $request->file('file'), $filename);

            return $filename;
        }



    }

}
