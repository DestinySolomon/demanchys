<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
   
public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048',
        'category' => 'required|string',
    ]);

    $path = $request->file('image')->store('gallery', 'public');

    GalleryImage::create([
        'image_path' => $path,
        'category' => $request->category,
    ]);

    return back()->with('success', 'Image uploaded successfully.');
}


public function index(Request $request)
{
    $category = $request->get('category');

    $query = GalleryImage::query();

    if ($category) {
        $query->where('category', $category);
    }

    $images = $query->orderBy('id', 'desc')->paginate(14);

    return view('gallery', compact('images', 'category'));
}}