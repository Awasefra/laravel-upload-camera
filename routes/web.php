<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;


Route::get('/', [ImageUploadController::class, 'index']);
Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('upload.image');
Route::post('/upload-image-2', [ImageUploadController::class, 'store2'])->name('upload.image2');
