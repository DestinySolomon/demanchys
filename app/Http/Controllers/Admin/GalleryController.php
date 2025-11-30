<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = GalleryImage::orderBy('created_at', 'desc')->get();
        return view('admin.gallery.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = GalleryImage::CATEGORIES;
        return view('admin.gallery.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category' => 'required|in:' . implode(',', array_keys(GalleryImage::CATEGORIES)),
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gallery', 'public');
            
            GalleryImage::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'image_path' => $imagePath
            ]);

            return redirect()->route('admin.gallery.index')->with('success', 'Image added successfully!');
        }

        return back()->with('error', 'Image upload failed!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not needed for gallery
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $image = GalleryImage::findOrFail($id);
        $categories = GalleryImage::CATEGORIES;
        return view('admin.gallery.edit', compact('image', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $image = GalleryImage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category' => 'required|in:' . implode(',', array_keys(GalleryImage::CATEGORIES)),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
        ];

        // Handle image update if new image is uploaded
        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($image->image_path);
            
            // Store new image
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $image->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = GalleryImage::findOrFail($id);
        
        // Delete image file from storage
        Storage::disk('public')->delete($image->image_path);
        
        $image->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Image deleted successfully!');
    }
}