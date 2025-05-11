<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        // Store the file
        $filename = time() . '_' . $request->file('document')->getClientOriginalName();
        $path = $request->file('document')->storeAs('uploads', $filename, 'public');

        $url = asset('storage/' . $path);
        // Return a response
        return response()->json(['url' => $url], 200);
        
    }
}