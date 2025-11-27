<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = MenuCategory::withCount('items')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a new category
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:menu_categories',
    //         'description' => 'nullable|string',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('category-images', 'public');
    //     }

    //     MenuCategory::create([
    //         'name' => $request->name,
    //         'slug' => Str::slug($request->name),
    //         'description' => $request->description,
    //         'image' => $imagePath,
    //     ]);

    //     return redirect()->route('admin.categories.index')
    //         ->with('success', 'Category created successfully!');
    // }
     public function store(Request $request)
       {
    $request->validate([
        'name' => 'required|string|max:255|unique:menu_categories',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = $request->hasFile('image') 
        ? $request->file('image')->store('category-images', 'public')
        : null;

    MenuCategory::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'image' => $imagePath,
    ]);

    return redirect()->route('admin.categories.index')
        ->with('success', 'Category created successfully!');
}
    /**
     * Update a category
     */
    public function update(Request $request, $id)
    {
        $category = MenuCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:menu_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('category-images', 'public');
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Delete a category
     */
    /**
     * Delete a category
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Log::info('Delete method called for category ID: ' . $id);

        try {
            $category = MenuCategory::findOrFail($id);
            Log::info('Category found: ' . $category->name);

            // Delete category image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
                Log::info('Image deleted: ' . $category->image);
            }

            $category->delete();
            Log::info('Category deleted successfully');

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Delete error: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')
                ->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}