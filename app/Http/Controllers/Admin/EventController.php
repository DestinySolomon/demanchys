<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of all events.
     */
    public function index()
    {
        $events = Event::latest()->paginate(10);
        $upcomingCount = Event::upcoming()->count();
        $ongoingCount = Event::ongoing()->count();
        $pastCount = Event::past()->count();
            
        return view('admin.events.index', compact('events', 'upcomingCount', 'ongoingCount', 'pastCount'));
    }

    /**
     * Display upcoming events.
     */
    public function upcoming()
    {
        $events = Event::upcoming()->paginate(10);
        return view('admin.events.upcoming', compact('events'));
    }

    /**
     * Display ongoing events.
     */
    public function ongoing()
    {
        $events = Event::ongoing()->paginate(10);
        return view('admin.events.ongoing', compact('events'));
    }

    /**
     * Display past events.
     */
    public function past()
    {
        $events = Event::past()->paginate(10);
        return view('admin.events.past', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'event_date' => 'required|date|after:now',
            'event_type' => 'required|in:party,corporate,special_dinner,live_music,wine_tasting,cooking_class,other',
            'location' => 'nullable|string|max:500',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published,cancelled,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $safeName = Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            
            $imagePath = $request->file('image')->storeAs(
                'events', 
                $safeName, 
                'public'
            );
        }

        // Create event
        Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'event_type' => $validated['event_type'],
            'location' => $validated['location'] ?? null,
            'capacity' => $validated['capacity'] ?? null,
            'price' => $validated['price'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'contact_phone' => $validated['contact_phone'] ?? null,
            'category' => $validated['category'] ?? null,
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.events.index')
                        ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event.
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'event_date' => 'required|date',
            'event_type' => 'required|in:party,corporate,special_dinner,live_music,wine_tasting,cooking_class,other',
            'location' => 'nullable|string|max:500',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published,cancelled,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle image upload
        $imagePath = $event->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $safeName = Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            
            $imagePath = $request->file('image')->storeAs(
                'events', 
                $safeName, 
                'public'
            );
        }

        // Update event
        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'event_type' => $validated['event_type'],
            'location' => $validated['location'] ?? null,
            'capacity' => $validated['capacity'] ?? null,
            'price' => $validated['price'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'contact_phone' => $validated['contact_phone'] ?? null,
            'category' => $validated['category'] ?? null,
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.events.index')
                        ->with('success', 'Event updated successfully!');
    }

    /**
     * Update event status.
     */
    public function updateStatus(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,published,cancelled,completed',
        ]);

        $event->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Event status updated successfully!');
    }

    /**
     * Remove the specified event.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // Delete associated image
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();

        return redirect()->route('admin.events.index')
                        ->with('success', 'Event deleted successfully!');
    }
}