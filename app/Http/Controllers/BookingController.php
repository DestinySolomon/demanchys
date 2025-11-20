<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
class BookingController extends Controller
{
     public function create()
    {
        return view('book-table');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'guests'    => 'required|integer|min:1',
            'date'      => 'required|date|after_or_equal:today',
            'time'      => 'required|string',
            'note'      => 'nullable|string',
        ]);

        Booking::create($request->all());

        return back()->with('success', 'Your table has been successfully booked!');
    }
}
