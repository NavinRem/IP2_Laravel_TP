<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            $path = $request->file('image')->store('gallery', 'minio');

            if (!$path) {
                return response()->json(['error' => 'Upload failed. No path returned.'], 500);
            }

            // Optional: Make it public
            // Storage::disk('minio')->setVisibility($path, 'public');

                    // Get original image content
            $imageContent = file_get_contents($request->file('image')->getRealPath());

            // Create thumbnail (e.g., 300x200)
            $thumbnail = Image::make($imageContent)
                ->resize(300, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode();

            // Save thumbnail to 'gallery/thumbnails' folder with same filename
            $thumbnailPath = 'gallery/thumbnails/' . basename($path);

            // Store thumbnail on the same disk (MinIO)
            Storage::disk('minio')->put($thumbnailPath, (string) $thumbnail);

            // Optionally make them public
            Storage::disk('minio')->setVisibility($path, 'public');
            Storage::disk('minio')->setVisibility($thumbnailPath, 'public');


            return response()->json([
                'message' => 'Image and thumbnail uploaded successfully!',
                'path' => $path,
                'thumbnail_path' => $thumbnailPath,
                'url' => Storage::disk('minio')->url($path),
                'thumbnail_url' => Storage::disk('minio')->url($thumbnailPath),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
