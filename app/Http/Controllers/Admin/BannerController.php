<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function promotional()
    {
        $banners = Banner::where('type', 'promotional')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.banners.promotional.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPromotional()
    {
        return view('admin.banners.promotional.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePromotional(Request $request)
    {
        $validated = $this->validateBanner($request, 'promotional');
        $validated['type'] = 'promotional';

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('banners/promotional', 'public');
        }

        $validated['order'] = $this->getNextOrder('promotional');

        Banner::create($validated);

        return redirect()->route('admin.banners.promotional')
            ->with('success', 'Promotional banner created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function offers()
    {
        $offers = Banner::where('type', 'offer')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.banners.offers.index', compact('offers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function createOffer()
    {
        return view('admin.banners.offers.create');
    }

    /**
     * Update the specified resource in storage.
     */
    public function storeOffer(Request $request)
    {
        $validated = $this->validateBanner($request, 'offer');
        $validated['type'] = 'offer';

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('banners/offers', 'public');
        }

        $validated['order'] = $this->getNextOrder('offer');

        Banner::create($validated);

        return redirect()->route('admin.banners.offers')
            ->with('success', 'Offer deal created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $this->validateBanner($request, $banner->type, true);

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $validated['image_path'] = $request->file('image')->store("banners/{$banner->type}", 'public');
        }

        $banner->update($validated);

        $route = $banner->type === 'promotional' ? 'admin.banners.promotional' : 'admin.banners.offers';

        return redirect()->route($route)->with('success', ucfirst($banner->type).' updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $type = $banner->type;
        $banner->delete();

        $route = $type === 'promotional' ? 'admin.banners.promotional' : 'admin.banners.offers';

        return redirect()->route($route)->with('success', ucfirst($type).' deleted successfully!');
    }

    public function toggle(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);

        return redirect()->back()->with('success','Visibility updated!');
    }

    private function validateBanner(Request $request, $type, $isUpdate = false)
    {
        $rules = [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];

        if (!$isUpdate) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } else {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }

        $validated = $request->validate($rules);
        $validated['is_active'] = $request->has('is_active');

        return $validated;
    }

    private function getNextOrder($type)
    {
        $maxOrder = Banner::where('type', $type)->max('order');
        return ($maxOrder ?? 0) + 1;
    }
}
