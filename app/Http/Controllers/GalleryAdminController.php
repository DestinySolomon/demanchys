<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;

class GalleryAdminController extends Controller
{
    public function index()
    {
        $images = GalleryImage::latest()->get();
        return view('admin.gallery', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5000'
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        GalleryImage::create([
            'image_path' => $path
        ]);

        return back()->with('success', 'Image uploaded successfully!');
    }
}
