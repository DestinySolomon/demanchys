<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(Request $request)
    {
        $query = Testimonial::latest();
        
        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        $testimonials = $query->paginate(20);
        
        $featuredCount = Testimonial::where('is_featured', true)->count();
        $approvedCount = Testimonial::where('is_approved', true)->count();
        $pendingCount = Testimonial::where('is_approved', false)->count();
        $totalCount = Testimonial::count();
        
        return view('admin.testimonials.index', compact(
            'testimonials', 
            'featuredCount', 
            'approvedCount', 
            'pendingCount', 
            'totalCount'
        ));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'content' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'order' => 'nullable|integer|min:0'
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $validated['image'] = $imagePath;
        }
        
        // Convert checkbox values to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_approved'] = $request->has('is_approved');
        
        // Set default order if not provided
        if (!isset($validated['order'])) {
            $maxOrder = Testimonial::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }
        
        Testimonial::create($validated);
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    /**
     * Display the specified testimonial.
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'content' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'order' => 'nullable|integer|min:0'
        ]);
        
        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Keep existing image if not updating
            $validated['image'] = $testimonial->image;
        }
        
        // Convert checkbox values to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_approved'] = $request->has('is_approved');
        
        $testimonial->update($validated);
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete image if exists
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }
        
        $testimonial->delete();
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }
    
    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);
        
        return redirect()->back()
            ->with('success', 'Featured status updated!');
    }
    
    /**
     * Toggle approved status.
     */
    public function toggleApproved(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);
        
        return redirect()->back()
            ->with('success', 'Approval status updated!');
    }
    
    /**
     * Bulk approve testimonials.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:testimonials,id'
        ]);
        
        Testimonial::whereIn('id', $request->ids)->update(['is_approved' => true]);
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', count($request->ids) . ' testimonials approved!');
    }
    
    /**
     * Update testimonial order.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'testimonials' => 'required|array',
            'testimonials.*.id' => 'required|exists:testimonials,id',
            'testimonials.*.order' => 'required|integer'
        ]);
        
        foreach ($request->testimonials as $testimonial) {
            Testimonial::where('id', $testimonial['id'])->update(['order' => $testimonial['order']]);
        }
        
        return response()->json(['success' => true]);
    }
}