<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function upload(Request $request)
{
    try {
        // Validate image
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('image');
        $filename = uniqid('gallery_') . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('minio')->putFileAs('gallery', $file, $filename);

        if (!$path) {
            \Log::error('putFileAs returned false');
            return response()->json(['error' => 'File upload failed'], 500);
        }

        $url = rtrim(env('MINIO_ENDPOINT'), '/') . '/' . env('MINIO_BUCKET') . '/' . $path;

        \Log::info('File uploaded successfully to MinIO at path: ' . $path);
        \Log::info('Generated URL: ' . $url);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $path,
            'url' => $url
        ]);
    } catch (\Throwable $e) {
        \Log::error('Upload failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'request' => $request->all(),
        ]);
        return response()->json(['error' => 'File upload failed'], 500);        
    }
}
}
