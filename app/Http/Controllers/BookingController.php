<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Notification;

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

        $booking = Booking::create($request->all());

        // Notify all admin users of the new booking
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::createNotification(
                'booking',
                'New Table Booking',
                "{$booking->name} booked a table for {$booking->guests} guests on {$booking->date} at {$booking->time}",
                $admin,
                [
                    'booking_id' => $booking->id,
                    'booking_name' => $booking->name,
                    'booking_guests' => $booking->guests,
                    'booking_date' => $booking->date,
                    'booking_time' => $booking->time,
                ]
            );
        }

        return back()->with('success', 'Your table has been successfully booked!');
    }
}
