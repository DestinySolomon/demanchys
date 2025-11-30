<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddOn;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AddOnController extends Controller
{
    /**
     * Display a listing of add-ons.
     */
    public function index()
    {
        $addOns = AddOn::orderBy('sort_order')
                      ->orderBy('name')
                      ->get();
            
        return view('admin.add-ons.index', compact('addOns'));
    }

    /**
     * Show the form for creating a new add-on.
     */
    public function create()
    {
        $menuItems = MenuItem::where('is_available', true)
                           ->orderBy('name')
                           ->get();
        
        return view('admin.add-ons.create', compact('menuItems'));
    }

    /**
     * Store a newly created add-on.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('add_ons')
            ],
            'description' => 'nullable|string|max:1000',
            'additional_price' => 'required|numeric|min:0|max:99999.99',
            'is_available' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'menu_items' => 'nullable|array',
            'menu_items.*' => 'exists:menu_items,id',
        ]);

        // Create the add-on
        $addOn = AddOn::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'additional_price' => $validated['additional_price'],
            // Use boolean() to properly capture checkbox value even when a hidden input is present
            'is_available' => $request->boolean('is_available'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        // Attach menu items if provided
        if ($request->has('menu_items')) {
            $menuItemData = [];
            foreach ($request->menu_items as $menuItemId) {
                $menuItemData[$menuItemId] = ['additional_price' => $validated['additional_price']];
            }
            $addOn->menuItems()->sync($menuItemData);
        }

        return redirect()->route('admin.add-ons.index')
                        ->with('success', 'Add-on created successfully!');
    }

    /**
     * Show the form for editing the specified add-on.
     */
    public function edit($id)
    {
        $addOn = AddOn::findOrFail($id);
        $menuItems = MenuItem::where('is_available', true)
                           ->orderBy('name')
                           ->get();
        
        return view('admin.add-ons.edit', compact('addOn', 'menuItems'));
    }

    /**
     * Update the specified add-on.
     */
    public function update(Request $request, $id)
    {
        $addOn = AddOn::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('add_ons')->ignore($addOn->id)
            ],
            'description' => 'nullable|string|max:1000',
            'additional_price' => 'required|numeric|min:0|max:99999.99',
            'is_available' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'menu_items' => 'nullable|array',
            'menu_items.*' => 'exists:menu_items,id',
        ]);

        // Update the add-on
        $addOn->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'additional_price' => $validated['additional_price'],
            // Use boolean() to properly capture checkbox value even when a hidden input is present
            'is_available' => $request->boolean('is_available'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        // Sync menu items
        $menuItemData = [];
        if ($request->has('menu_items')) {
            foreach ($request->menu_items as $menuItemId) {
                $menuItemData[$menuItemId] = ['additional_price' => $validated['additional_price']];
            }
        }
        $addOn->menuItems()->sync($menuItemData);

        return redirect()->route('admin.add-ons.index')
                        ->with('success', 'Add-on updated successfully!');
    }

    /**
     * Remove the specified add-on.
     */
    public function destroy($id)
    {
        $addOn = AddOn::findOrFail($id);
        
        // Detach all menu items first
        $addOn->menuItems()->detach();
        
        $addOn->delete();

        return redirect()->route('admin.add-ons.index')
                        ->with('success', 'Add-on deleted successfully!');
    }

    /**
     * Get add-ons for a specific menu item (API endpoint)
     */
    public function getByMenuItem($menuItemId)
    {
        $menuItem = MenuItem::findOrFail($menuItemId);
        $addOns = $menuItem->addons()->where('is_available', true)->get();

        return response()->json($addOns);
    }
}