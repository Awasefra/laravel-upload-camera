<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10240 KB atau 10 MB
        ]);


        if ($request->hasFile('image')) {
            // Simpan gambar ke folder public/images
            $path = $request->file('image')->store('public/images');
            $filename = basename($path);

            return back()->with('success', 'Gambar berhasil diunggah!')->with('filename', $filename);
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }
}
