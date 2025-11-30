<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::published();
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        // Filter by status (Upcoming/Past)
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'Upcoming') {
                $query->upcoming();
            } elseif ($request->status == 'Past') {
                $query->past();
            }
        } else {
            // Default: show both upcoming and past events
            $query->where(function($q) {
                $q->upcoming()->orWhere(function($q2) {
                    $q2->past();
                });
            });
        }
        
        $events = $query->orderBy('event_date', 'desc')->paginate(9);
        
        return view('events', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        if ($event->status !== 'published') {
            abort(404);
        }

        return view('events.show', compact('event'));
    }
}