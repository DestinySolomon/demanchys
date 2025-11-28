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
     * Display a listing of menu items
     */
    public function index()
    {
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
     * Store a newly created menu item
     */
    public function store(Request $request)
    {


                
        // NOTE: removed verbose debug logs — we will read values properly using boolean() below







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
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'is_available' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // File upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $safeName = Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            
            $imagePath = $request->file('image')->storeAs(
                'menu-items', 
                $safeName, 
                'public'
            );
        }

        MenuItem::create([
            'menu_category_id' => $validated['menu_category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            // Use boolean() to correctly parse the submitted value (works whether a hidden input is present)
            'is_available' => $request->boolean('is_available'),
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
     * Update the specified menu item
     */
    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

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
            'is_available' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // File update
        $imagePath = $menuItem->image;
        if ($request->hasFile('image')) {
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $safeName = Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            
            $imagePath = $request->file('image')->storeAs(
                'menu-items', 
                $safeName, 
                'public'
            );
        }

        $menuItem->update([
            'menu_category_id' => $validated['menu_category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'is_available' => $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item
     */
    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }
        
        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')
            ->with('success', 'Menu item deleted successfully!');
    }
}