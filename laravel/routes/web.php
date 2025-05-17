<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/upload_file', function () {
    return view('upload_file');
});
Route::post('/upload_file', [UploadController::class, 'upload'])->name('upload');


Route::get('/upload_gallery', function () {
    return view('upload_gallery');
});
Route::post('/upload_gallery', [GalleryController::class, 'upload'])->name('upload');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
