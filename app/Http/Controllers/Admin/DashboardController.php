<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Initialize all variables with defaults
        $defaults = [
            'orderStats' => ['active' => 0, 'pending' => 0, 'completed' => 0, 'canceled' => 0],
            'totalEarnings' => 0,
            'totalPending' => 0,
            'userStats' => ['total' => 0, 'admins' => 0, 'super_admins' => 0, 'regular_users' => 0],
            'recentOrders' => collect(),
            'recentUsers' => collect(),
            'upcomingEvents' => collect(),
            'todayBookings' => 0,
            'unreadContacts' => 0,
        ];
        
        try {
            // User Statistics - First calculate to ensure it's always set
            $userStats = [
                'total' => User::count(),
                'admins' => User::where('role', 'admin')->count(),
                'super_admins' => User::where('role', 'super_admin')->count(),
                'regular_users' => User::where('role', 'user')->count(),
            ];
            
            // Log actual user count for debugging
            Log::info('Total Users Count: ' . User::count());
            Log::info('User Stats Calculated:', $userStats);
            
            // Order Statistics - with fallback column names
            $orderStats = [
                'active' => Order::where('order_status', 'pending')->count(),
                'pending' => Order::where('order_status', 'pending')->count(),
                'completed' => Order::where('order_status', 'completed')->count(),
                'canceled' => Order::where('order_status', 'cancelled')
                    ->orWhere('order_status', 'canceled')
                    ->count(),
            ];
            
            // Financial Statistics
            $totalEarnings = Order::where('order_status', 'completed')->sum('total_amount') ?? 0;
            $totalPending = Order::where('order_status', 'pending')->sum('total_amount') ?? 0;
            
            // Recent Data
            $recentOrders = Order::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            $recentUsers = User::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            // Upcoming Events - Using correct column name 'event_date'
            $upcomingEvents = Event::where('event_date', '>=', now()->toDateString())
                ->where('status', 'published')
                ->orderBy('event_date', 'asc')
                ->limit(3)
                ->get();
                
            // Today's Bookings
            $todayBookings = Booking::whereDate('date', today())
                ->count();
                
            // Unread Contacts
            $unreadContacts = Contact::where('status', 'unread')
                ->count();
            
            // Return with all calculated data
            return view('admin.dashboard.index', [
                'orderStats' => $orderStats,
                'totalEarnings' => $totalEarnings,
                'totalPending' => $totalPending,
                'userStats' => $userStats,
                'recentOrders' => $recentOrders,
                'recentUsers' => $recentUsers,
                'upcomingEvents' => $upcomingEvents,
                'todayBookings' => $todayBookings,
                'unreadContacts' => $unreadContacts,
            ]);
            
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Dashboard Error: ' . $e->getMessage());
            Log::error('Error Trace: ' . $e->getTraceAsString());
            
            // Return defaults on error
            return view('admin.dashboard.index', $defaults);
        }
    }

    // Add this method to your DashboardController:
public function getChartData(Request $request)
{
    $days = $request->get('days', 30);
    
    $dates = [];
    $ordersData = [];
    
    for ($i = $days - 1; $i >= 0; $i--) {
        $date = now()->subDays($i)->toDateString();
        $dates[] = now()->subDays($i)->format('M d');
        
        // Count orders for this date
        $orderCount = Order::whereDate('created_at', $date)->count();
        $ordersData[] = $orderCount;
    }
    
    return response()->json([
        'dates' => $dates,
        'orders' => $ordersData
    ]);
}

/**
 * Get filtered users by role
 */
public function getFilteredUsers(Request $request)
{
    $role = $request->get('role');
    $search = $request->get('search');
    
    $query = User::orderBy('created_at', 'desc');
    
    // Filter by role if provided
    if ($role && $role !== '') {
        $query->where('role', $role);
    }
    
    // Search by name or email if provided
    if ($search && $search !== '') {
        $search = strtolower($search);
        $query->where(function($q) use ($search) {
            $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
              ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"]);
        });
    }
    
    $users = $query->limit(10)->get();
    
    return response()->json([
        'users' => $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at->format('M d, Y'),
            ];
        })
    ]);
}
}