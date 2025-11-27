<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    /**
     * Display a listing of menu items with security
     */
    public function index()
    {
        // Eager load relationships to prevent N+1 queries
        $menuItems = MenuItem::with('category')
            ->orderBy('sort_order')
            ->get();
            
        return view('admin.menu-items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new menu item
     */
      public function create()
  {
    $categories = MenuCategory::orderBy('name')->get();
    return view('admin.menu-items.create', compact('categories'));
  }

    /**
     * Store a newly created menu item with validation
     */
    public function store(Request $request)
    {
        // STRICT VALIDATION
        $validated = $request->validate([
            'menu_category_id' => 'required|exists:menu_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_items')->where(function ($query) use ($request) {
                    return $query->where('menu_category_id', $request->menu_category_id);
                })
            ],
            'description' => 'nullable|string|max:1000', // Limit description length
            'price' => 'required|numeric|min:0.01|max:999999.99', // Price bounds
            'availability' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max, specific types
        ]);

        // SECURE FILE UPLOAD
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Generate secure filename
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $safeName = Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            
            $imagePath = $request->file('image')->storeAs(
                'menu-items', 
                $safeName, 
                'public'
            );
        }

        // CREATE WITH VALIDATED DATA ONLY (no mass assignment vulnerability)
        MenuItem::create([
            'menu_category_id' => $validated['menu_category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
                'availability' => $request->boolean('availability'),
                // Read the actual boolean value instead of using has(),
                // which returns true even when a hidden input with value "0" exists.
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item created successfully!');
    }

    /**
     * Show the form for editing the specified menu item
     */
       public function edit($id)
{
    $menuItem = MenuItem::findOrFail($id);
    $categories = MenuCategory::orderBy('name')->get();
    
    return view('admin.menu-items.edit', compact('menuItem', 'categories'));
}

    /**
     * Update the specified menu item with validation
     */
    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        // VALIDATION WITH IGNORE UNIQUE RULE FOR CURRENT ITEM
        $validated = $request->validate([
            'menu_category_id' => 'required|exists:menu_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_items')
                    ->ignore($menuItem->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('menu_category_id', $request->menu_category_id);
                    })
            ],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'availability' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // SECURE FILE UPDATE
        $imagePath = $menuItem->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            
            // Generate secure filename
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $safeName = Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            
            $imagePath = $request->file('image')->storeAs(
                'menu-items', 
                $safeName, 
                'public'
            );
        }

        // UPDATE WITH VALIDATED DATA ONLY
        $menuItem->update([
            'menu_category_id' => $validated['menu_category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
                'availability' => $request->boolean('availability'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item with security
     */
    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        
        // Delete associated image file
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }
        
        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item deleted successfully!');
    }

    /**
     * Get image URL accessor (for secure file display)
     */
    // NOTE: image accessor belongs on the MenuItem model (getImageUrlAttribute).
    // It was incorrectly added to the controller and caused "$this->image" undefined
    // property errors. The model already provides this accessor so remove it from
    // the controller to avoid runtime errors and linter warnings.
}