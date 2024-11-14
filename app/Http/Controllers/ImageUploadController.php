<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageUploadController extends Controller
{
    public function index()
    {
        // Ambil semua file yang ada di folder public/images
        $images = File::allFiles(public_path('storage/images'));

        // Mengambil nama file saja tanpa path lengkap
        $imagePaths = array_map(function ($image) {
            return 'storage/images/' . $image->getRelativePathname();
        }, $images);

        // Kirim daftar gambar ke view
        return view('welcome', compact('imagePaths'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10240 KB atau 10 MB
        ]);


        if ($request->hasFile('image')) {
            // Simpan gambar ke folder public/images
            $path = $request->file('image')->store('images', 'public');
            $filename = basename($path);

            return back()->with('success', 'Gambar berhasil diunggah!')->with('filename', $filename);
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    public function store2(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Pastikan 'image' adalah string Base64
        ]);

        // Ambil data Base64 dari input
        $imageData = $request->input('image');

        // Menghapus bagian "data:image/jpeg;base64," atau "data:image/png;base64," dari data
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        $imageData = base64_decode($imageData);

        // Generate nama file yang unik
        $imageName = uniqid() . '.jpg';  // Anda bisa mengganti ekstensi jika format gambar berbeda

        // Simpan gambar ke public/images
        $path = storage_path('app/public/images/' . $imageName);
        file_put_contents($path, $imageData);

        return back()->with('success', 'Gambar berhasil diunggah!')->with('filename', $imageName);
    }
}
