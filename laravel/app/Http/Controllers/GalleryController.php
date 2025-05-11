<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the image
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload to MinIO
        $file = $request->file('image');
        $filename = uniqid('gallery_') . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('minio')->putFileAs('gallery', $file, $filename);

        // Generate URL (public bucket assumed)
        $url = env('MINIO_ENDPOINT') . '/' . env('MINIO_BUCKET') . '/' . $path;

        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $path,
            'url' => $url
        ]);
    }
}
