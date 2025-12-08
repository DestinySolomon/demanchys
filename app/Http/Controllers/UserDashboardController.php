<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Wishlist;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard with actual data
     */
    public function dashboard()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // Get order statistics - USING YOUR ACTUAL ORDER STATUSES
        $orderStats = [
            'active' => Order::where('user_id', $userId)
                            ->whereIn('order_status', ['pending', 'processing', 'confirmed'])
                            ->count(),
            'total' => Order::where('user_id', $userId)->count(),
            'completed' => Order::where('user_id', $userId)
                              ->where('order_status', 'completed')
                              ->count(),
            'cancelled' => Order::where('user_id', $userId)
                               ->where('order_status', 'cancelled')
                               ->count(),
        ];
        
        // Get booking statistics - USING YOUR ACTUAL BOOKINGS TABLE
        $bookingStats = [
            'upcoming' => Booking::where('email', $user->email) // Using email since bookings might not have user_id
                                ->where('date', '>=', now()->format('Y-m-d'))
                                ->whereIn('status', ['confirmed', 'pending'])
                                ->count(),
            'total' => Booking::where('email', $user->email)->count(),
            'confirmed' => Booking::where('email', $user->email)
                                 ->where('status', 'confirmed')
                                 ->count(),
        ];
        
        // Get recent orders (last 5) with items count
        $recentOrders = Order::where('user_id', $userId)
                            ->withCount(['items' => function($query) {
                                $query->select(DB::raw('SUM(quantity)'));
                            }])
                            ->latest()
                            ->take(5)
                            ->get();
        
        // Get upcoming bookings (next 3)
        $upcomingBookings = Booking::where('email', $user->email)
                                  ->where('date', '>=', now()->format('Y-m-d'))
                                  ->whereIn('status', ['confirmed', 'pending'])
                                  ->orderBy('date')
                                  ->orderBy('time')
                                  ->take(3)
                                  ->get();
        
        // For wishlist - count actual wishlist items for the user
        try {
            $wishlistCount = \App\Models\Wishlist::where('user_id', $userId)->count();
        } catch (\Exception $e) {
            $wishlistCount = 0;
        }
        
        return view('user.dashboard.index', compact(
            'orderStats',
            'bookingStats',
            'wishlistCount',
            'recentOrders',
            'upcomingBookings',
            'user'
        ));
    }
    
    /**
     * Display edit profile page
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.dashboard.edit-profile', compact('user'));
    }
    
    /**
     * Update user profile
     */
   public function updateProfile(Request $request)
{
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (! $user) {
        abort(403);
    }
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'mobile_number' => 'nullable|string|max:20',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'nullable|string|max:500',
        'bio' => 'nullable|string|max:1000',
        'facebook_url' => 'nullable|url|max:255',
        'twitter_url' => 'nullable|url|max:255',
        'instagram_url' => 'nullable|url|max:255',
        'linkedin_url' => 'nullable|url|max:255',
    ]);
    
    $user->name = $request->name;
    $user->email = $request->email;
    $user->mobile_number = $request->mobile_number;
    $user->address = $request->address;
    $user->bio = $request->bio;
    $user->facebook_url = $request->facebook_url;
    $user->twitter_url = $request->twitter_url;
    $user->instagram_url = $request->instagram_url;
    $user->linkedin_url = $request->linkedin_url;
    
        if ($request->hasFile('profile_image')) {
            // Delete old profile image if exists
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
    
    $user->save();
    
    return redirect()->route('user.edit-profile')
        ->with('success', 'Profile updated successfully!');
}
    /**
     * Display address page
     */
    public function address()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }
        // Since you don't have Address model yet, we'll use user's address from orders
        $recentAddresses = Order::where('user_id', $user->id)
                               ->whereNotNull('customer_address')
                               ->select('customer_address')
                               ->distinct()
                               ->latest()
                               ->take(5)
                               ->get()
                               ->pluck('customer_address');
        
        return view('user.dashboard.address', compact('user', 'recentAddresses'));
    }

    /**
 * Store address (update user's primary address)
 */
public function storeAddress(Request $request)
{
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (! $user) {
        abort(403);
    }
    
    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
        'landmark' => 'nullable|string|max:255',
        'address_type' => 'nullable|string|in:home,work,other',
    ]);
    
    $user->name = $request->full_name;
    $user->mobile_number = $request->phone;
    $user->address = $request->address;
    $user->save();
    
    return redirect()->route('user.address')
        ->with('success', 'Address added successfully!');
}

/**
 * Update address
 */
public function updateAddress(Request $request)
{
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (! $user) {
        abort(403);
    }
    
    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
    ]);
    
    $user->name = $request->full_name;
    $user->mobile_number = $request->phone;
    $user->address = $request->address;
    $user->save();
    
    return redirect()->route('user.address')
        ->with('success', 'Address updated successfully!');
}

/**
 * Delete address
 */
public function deleteAddress(Request $request)
{
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (! $user) {
        abort(403);
    }
    
    $user->address = null;
    $user->save();
    
    return redirect()->route('user.address')
        ->with('success', 'Address removed successfully!');
}

/**
 * Save delivery instructions
 */
public function saveInstructions(Request $request)
{
    $request->validate([
        'delivery_instructions' => 'nullable|string|max:1000',
    ]);
    
    // Store in session or database
    session(['delivery_instructions' => $request->delivery_instructions]);
    
    return redirect()->route('user.address')
        ->with('success', 'Delivery instructions saved!');
}
    
    /**
     * Display orders page with pagination
     */
    public function orders()
    {
        $user = Auth::user();
        
        $orders = Order::where('user_id', $user->id)
                      ->with(['items.menuItem' => function($query) {
                          $query->select('id', 'name', 'price', 'image');
                      }])
                      ->withCount(['items as total_items' => function($query) {
                          $query->select(DB::raw('SUM(quantity)'));
                      }])
                      ->latest()
                      ->paginate(10);
        
        return view('user.dashboard.orders', compact('user', 'orders'));
    }
    
    /**
     * Display order details
     */
    public function showOrder($id)
    {
        $order = Order::where('user_id', Auth::id())
                     ->with(['items.menuItem' => function($query) {
                         $query->select('id', 'name', 'price', 'image', 'description');
                     }])
                     ->findOrFail($id);
        
        return view('user.dashboard.order-show', compact('order'));
    }


    /**
 * Cancel an order
 */
public function cancelOrder(Request $request, $id)
{
    $order = Order::where('user_id', Auth::id())->findOrFail($id);
    
    // Only allow cancellation if order is pending or processing
    if (!in_array($order->order_status, ['pending', 'processing'])) {
        return redirect()->route('user.orders')
            ->with('error', 'Order cannot be cancelled at this stage.');
    }
    
    $order->order_status = 'cancelled';
    $order->save();
    
    return redirect()->route('user.orders')
        ->with('success', 'Order cancelled successfully.');
}
    
    /**
     * Display bookings page
     */
    public function bookings()
    {
        $user = Auth::user();
        
        $bookings = Booking::where('email', $user->email)
                          ->latest()
                          ->paginate(10);
        
        // Calculate booking statistics
        $bookingStats = [
            'total' => Booking::where('email', $user->email)->count(),
            'upcoming' => Booking::where('email', $user->email)
                                ->where('date', '>=', now()->format('Y-m-d'))
                                ->whereIn('status', ['confirmed', 'pending'])
                                ->count(),
            'confirmed' => Booking::where('email', $user->email)
                                 ->where('status', 'confirmed')
                                 ->count(),
            'pending' => Booking::where('email', $user->email)
                               ->where('status', 'pending')
                               ->count(),
        ];
        
        return view('user.dashboard.bookings', compact('user', 'bookings', 'bookingStats'));
    }
    
    /**
     * Display booking details
     */
    public function showBooking($id)
    {
        $booking = Booking::where('email', Auth::user()->email)
                         ->findOrFail($id);
        
        return view('user.dashboard.booking-show', compact('booking'));
    }

    /**
 * Cancel a booking
 */
public function cancelBooking(Request $request, $id)
{
    $booking = Booking::where('email', Auth::user()->email)->findOrFail($id);
    
    // Only allow cancellation if booking is in future
    $bookingDateTime = \Carbon\Carbon::parse($booking->date)->setTimeFromTimeString($booking->time);
    if ($bookingDateTime->isPast()) {
        return redirect()->route('user.bookings')
            ->with('error', 'Cannot cancel past bookings.');
    }
    
    $booking->status = 'cancelled';
    $booking->save();
    
    return redirect()->route('user.bookings')
        ->with('success', 'Booking cancelled successfully.');
}
    
    /**
     * Display wishlist page - PLACEHOLDER since you don't have wishlist table
     */
    public function wishlist()
    {
        $user = Auth::user();
        // Load wishlist items for the authenticated user
        $wishlistItems = \App\Models\Wishlist::where('user_id', $user->id)
                            ->with('menuItem')
                            ->orderByDesc('created_at')
                            ->get();

        // Calculate total value
        $totalValue = $wishlistItems->reduce(function ($carry, $item) {
            return $carry + (($item->menuItem->price ?? 0) );
        }, 0);

        return view('user.dashboard.wishlist', compact('user', 'wishlistItems', 'totalValue'));
    }
    
    /**
     * Display reviews page - PLACEHOLDER
     */
    public function reviews()
    {
        $user = Auth::user();
        $reviews = collect(); // Empty collection for now
        
        return view('user.dashboard.reviews', compact('user', 'reviews'));
    }
    
    /**
     * Display change password page
     */
    public function changePassword()
    {
        $user = Auth::user();
        return view('user.dashboard.change-password', compact('user'));
    }
    
    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->route('user.dashboard')
            ->with('success', 'Password changed successfully!');
    }
    
    /**
     * Handle reorder request - ADD ACTUAL ITEMS TO CART
     */
    public function reorder(Request $request, $orderId)
    {
        $order = Order::where('user_id', Auth::id())
                     ->with('items.menuItem')
                     ->findOrFail($orderId);
        
        $cart = session()->get('cart', []);
        $itemsAdded = 0;
        
        foreach ($order->items as $orderItem) {
            if ($orderItem->menuItem) {
                $productId = $orderItem->menu_item_id;
                
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += $orderItem->quantity;
                } else {
                    $cart[$productId] = [
                        'name' => $orderItem->menuItem->name,
                        'quantity' => $orderItem->quantity,
                        'price' => $orderItem->menuItem->price,
                        'image' => $orderItem->menuItem->image,
                    ];
                }
                
                $itemsAdded++;
            }
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => $itemsAdded . ' item(s) added to cart successfully!',
            'items_added' => $itemsAdded,
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }
    
    /**
     * Get order items for reorder modal
     */
    public function getOrderItems($orderId)
    {
        $order = Order::where('user_id', Auth::id())
                     ->with('items.menuItem')
                     ->findOrFail($orderId);
        
        $items = $order->items->map(function ($item) {
            return [
                'id' => $item->menu_item_id,
                'name' => $item->menuItem->name ?? 'Unknown Item',
                'quantity' => $item->quantity,
                'price' => $item->menuItem->price ?? 0,
                'total' => $item->quantity * ($item->menuItem->price ?? 0),
            ];
        });
        
        return response()->json([
            'success' => true,
            'items' => $items,
            'order_total' => $order->total_amount,
        ]);
    }

    /**
 * Add item to wishlist
 */
public function addToWishlist(Request $request)
{
    $request->validate([
        'menu_item_id' => 'required|exists:menu_items,id',
    ]);
    
    $user = Auth::user();
    
    // Check if already in wishlist
    $exists = Wishlist::where('user_id', $user->id)
                     ->where('menu_item_id', $request->menu_item_id)
                     ->exists();
    
    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Item already in wishlist',
            'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
        ]);
    }
    
    // Add to wishlist
    Wishlist::create([
        'user_id' => $user->id,
        'menu_item_id' => $request->menu_item_id,
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Added to wishlist',
        'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
    ]);
}

/**
 * Remove item from wishlist
 */
public function removeFromWishlist(Request $request, $id)
{
    $user = Auth::user();
    
    // If ID is provided as parameter
    if ($id) {
        $wishlistItem = Wishlist::where('user_id', $user->id)
                               ->where('menu_item_id', $id)
                               ->first();
    } else {
        // If ID is in request
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
        ]);
        
        $wishlistItem = Wishlist::where('user_id', $user->id)
                               ->where('menu_item_id', $request->menu_item_id)
                               ->first();
    }
    
    if (!$wishlistItem) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in wishlist'
            ]);
        }
        return redirect()->route('user.wishlist')
                       ->with('error', 'Item not found in wishlist');
    }
    
    $wishlistItem->delete();
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist',
            'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
        ]);
    }
    
    return redirect()->route('user.wishlist')
                   ->with('success', 'Item removed from wishlist');
}

/**
 * Move wishlist item to cart
 */
public function moveToCart(Request $request, $id)
{
    $user = Auth::user();
    
    $wishlistItem = Wishlist::where('user_id', $user->id)
                           ->where('menu_item_id', $id)
                           ->with('menuItem')
                           ->first();
    
    if (!$wishlistItem) {
        return response()->json([
            'success' => false,
            'message' => 'Item not found in wishlist'
        ]);
    }
    
    // Get or create cart from session
    $cart = session()->get('cart', []);
    $menuItem = $wishlistItem->menuItem;
    
    if (!$menuItem->is_available) {
        return response()->json([
            'success' => false,
            'message' => 'This item is currently unavailable'
        ]);
    }
    
    // Add to cart
    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'name' => $menuItem->name,
            'quantity' => 1,
            'price' => $menuItem->price,
            'image' => $menuItem->image,
        ];
    }
    
    session()->put('cart', $cart);
    
    // Remove from wishlist
    $wishlistItem->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'Added to cart and removed from wishlist',
        'wishlist_count' => Wishlist::where('user_id', $user->id)->count(),
        'cart_count' => array_sum(array_column($cart, 'quantity'))
    ]);
}

/**
 * Clear all wishlist items
 */
public function clearWishlist()
{
    $user = Auth::user();
    
    Wishlist::where('user_id', $user->id)->delete();
    
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared',
            'wishlist_count' => 0
        ]);
    }
    
    return redirect()->route('user.wishlist')
                   ->with('success', 'Wishlist cleared successfully');
}
}