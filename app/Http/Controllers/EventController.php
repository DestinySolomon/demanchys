<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
     public function index()
    {
        $events = Event::orderBy('event_date', 'asc')->get();
        return view('events.index', compact('events'));
    }

    // ADMIN LIST
    public function adminIndex()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // ADMIN CREATE
    public function create()
    {
        return view('admin.events.create');
    }

    // ADMIN STORE
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required',
            'event_date'  => 'required|date',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'category'    => 'required|string',
            'status'      => 'required|in:Upcoming,Past',
        ]);

        $path = $request->file('image')->store('events', 'public');

        Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'event_date'  => $request->event_date,
            'image'       => $path,
            'category'    => $request->category,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event created successfully.');
    }

    // ADMIN EDIT
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // ADMIN UPDATE
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required',
            'event_date'  => 'required|date',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'category'    => 'required|string',
            'status'      => 'required|in:Upcoming,Past',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $event->image = $path;
        }

        $event->update($request->except('image'));

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event updated successfully.');
    }

    // ADMIN DELETE
    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Event deleted successfully.');
    }
}
