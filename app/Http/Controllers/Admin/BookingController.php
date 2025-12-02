<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::latest();
        
        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'cancelled', 'completed', 'no_show'])) {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }
        
        // Filter by today
        if ($request->has('today')) {
            $query->whereDate('date', today());
        }
        
        // Filter by upcoming
        if ($request->has('upcoming')) {
            $query->whereDate('date', '>=', today());
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%");
            });
        }
        
        $bookings = $query->paginate(20);
        
        // Stats
        $pendingCount = Booking::where('status', 'pending')->count();
        $confirmedCount = Booking::where('status', 'confirmed')->count();
        $todayCount = Booking::whereDate('date', today())->count();
        $upcomingCount = Booking::whereDate('date', '>=', today())->count();
        $totalCount = Booking::count();
        
        return view('admin.bookings.index', compact(
            'bookings',
            'pendingCount',
            'confirmedCount',
            'todayCount',
            'upcomingCount',
            'totalCount'
        ));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed,no_show',
            'admin_notes' => 'nullable|string|max:1000'
        ]);
        
        $oldStatus = $booking->status;
        $newStatus = $request->status;
        
        $booking->update([
            'status' => $newStatus,
            'admin_notes' => $request->admin_notes ?: $booking->admin_notes,
            'updated_by' => Auth::id()
        ]);
        
        // Send email notification if status changed to confirmed
        if ($newStatus === 'confirmed' && $booking->email) {
            $this->sendConfirmationEmail($booking);
        }
        
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Booking status updated from {$oldStatus} to {$newStatus}!");
    }

    /**
     * Send confirmation email.
     */
    private function sendConfirmationEmail(Booking $booking)
    {
        try {
            Mail::send('emails.booking_confirmation', [
                'booking' => $booking,
                'restaurant_name' => config('app.name', 'De Manchys Lounge')
            ], function($mail) use ($booking) {
                $mail->to($booking->email)
                     ->subject('Booking Confirmation - ' . config('app.name', 'De Manchys Lounge'));
            });
            
            // Log email sent
            $booking->update([
                'admin_notes' => ($booking->admin_notes ? $booking->admin_notes . "\n" : '') . 
                               'Confirmation email sent on ' . now()->format('Y-m-d H:i')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Booking confirmation email failed: ' . $e->getMessage());
        }
    }

    /**
     * Update admin notes.
     */
    public function updateNotes(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);
        
        $booking->update([
            'admin_notes' => $request->admin_notes,
            'updated_by' => Auth::id()
        ]);
        
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Admin notes updated!');
    }

    /**
     * Calendar view of bookings.
     */
    public function calendar(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        
        $bookings = Booking::whereYear('date', $year)
                          ->whereMonth('date', $month)
                          ->orderBy('date')
                          ->orderBy('time')
                          ->get()
                          ->groupBy(function($booking) {
                              return $booking->date->format('Y-m-d');
                          });
        
        return view('admin.bookings.calendar', compact('bookings', 'year', 'month'));
    }

    /**
     * Today's bookings.
     */
    public function today()
    {
        $bookings = Booking::whereDate('date', today())
                          ->orderBy('time')
                          ->get();
        
        return view('admin.bookings.today', compact('bookings'));
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
    
    /**
     * Bulk update status.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:bookings,id',
            'status' => 'required|in:pending,confirmed,cancelled,completed,no_show'
        ]);
        
        Booking::whereIn('id', $request->ids)->update([
            'status' => $request->status,
            'updated_by' => Auth::id()
        ]);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', count($request->ids) . ' bookings updated to ' . $request->status . '!');
    }
}