<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function upload(Request $request)
{
    $request->validate([
        'image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    try {
        $image = $request->file('image');
        $extension = strtolower($image->getClientOriginalExtension());
        $fileName = uniqid() . '.' . $extension;

        // Store original locally
        $localPath = $image->storeAs('gallery', $fileName, 'public');

        // Generate local thumbnail
        $thumbnail_local = 'thumbnails/' . $fileName;
        Image::make($image->getRealPath())
            ->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(storage_path('app/public/' . $thumbnail_local));

        // Save original to MinIO
        $fileContents = file_get_contents($image->getRealPath());
        $path = 'Gallery/' . $fileName;
        Storage::disk('minio')->put($path, $fileContents);
        Storage::disk('minio')->setVisibility($path, 'public');

        $thumbnail_minio = null;

        // Generate and upload thumbnail to MinIO if image
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $thumbnailImage = Image::make($image->getRealPath())
                ->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode($extension);

            $thumbnailPath = 'Thumbnails/' . $fileName;
            Storage::disk('minio')->put($thumbnailPath, (string) $thumbnailImage);
            $thumbnail_minio = $thumbnailPath;
        }

        return response()->json([
            'message' => 'Image and thumbnail uploaded successfully!',
            'path' => $path,
            'url' => Storage::disk('minio')->url($path),
            'thumbnail' => $thumbnail_minio
                ? Storage::disk('minio')->url($thumbnail_minio)
                : null,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Upload failed: ' . $e->getMessage(),
        ], 500);
    }
}

}
