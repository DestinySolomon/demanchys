<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    // Show gallery with pagination + filtering
    public function index(Request $request)
    {
        $category = $request->get('category');

        $query = GalleryImage::query();

        if ($category) {
            $query->where('category', $category);
        }

        $images = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Use the same categories as admin
        $categories = GalleryImage::CATEGORIES;

        return view('gallery', compact('images', 'category', 'categories'));
    }
}