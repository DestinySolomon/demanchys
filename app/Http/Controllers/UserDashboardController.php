<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Wishlist;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\CartItem;
use App\Models\Coupon;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard with actual data
     */
    public function dashboard()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
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
            'upcoming' => Booking::where('email', $user->email)
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
        $wishlistCount = Wishlist::where('user_id', $userId)->count();
        
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        return view('user.dashboard.edit-profile', compact('user'));
    }
    
    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
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
        if (!$user) {
            abort(403, 'User not authenticated');
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
        if (!$user) {
            abort(403, 'User not authenticated');
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
        if (!$user) {
            abort(403, 'User not authenticated');
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
        if (!$user) {
            abort(403, 'User not authenticated');
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        $order = Order::where('user_id', $user->id)
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        $order = Order::where('user_id', $user->id)->findOrFail($id);
        
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        $booking = Booking::where('email', $user->email)
                         ->findOrFail($id);
        
        return view('user.dashboard.booking-show', compact('booking'));
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking(Request $request, $id)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        $booking = Booking::where('email', $user->email)->findOrFail($id);
        
        // Only allow cancellation if booking is in future
        $bookingDateTime = Carbon::parse($booking->date)->setTimeFromTimeString($booking->time);
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
     * Display wishlist page
     */
    public function wishlist()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        // Load wishlist items for the authenticated user
        $wishlistItems = Wishlist::where('user_id', $user->id)
                            ->with('menuItem')
                            ->orderByDesc('created_at')
                            ->get();

        // Calculate total value
        $totalValue = $wishlistItems->reduce(function ($carry, $item) {
            return $carry + (($item->menuItem->price ?? 0));
        }, 0);

        return view('user.dashboard.wishlist', compact('user', 'wishlistItems', 'totalValue'));
    }
    
    /**
     * Display user's testimonials/reviews page
     */
    public function reviews()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        // Get user's submitted testimonials
        $testimonials = Testimonial::where('user_id', $user->id)
                               ->orWhere('email', $user->email)
                               ->latest()
                               ->get();
        
        // Check if user can submit new testimonial
        $canSubmit = $testimonials->where('is_approved', true)->count() == 0;
        
        return view('user.dashboard.reviews', compact('user', 'testimonials', 'canSubmit'));
    }
    
    /**
     * Display change password page
     */
    public function changePassword()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
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
        if (!$user) {
            abort(403, 'User not authenticated');
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
     * Display cart page
     */
public function viewCart()
{
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    $cartItems = [];
    $cartSubtotal = 0;
    $cartCount = 0;
    $appliedCoupon = null;
    $discountAmount = 0;
    $deliveryType = 'eat_in'; // Default
    
    if ($user) {
        // Get cart items from database for logged-in users
        $cartItems = CartItem::where('user_id', $user->id)
                            ->with('menuItem')
                            ->get();
        
        $cartCount = $cartItems->sum('quantity');
        $cartSubtotal = $cartItems->sum(function ($item) {
            return ($item->menuItem->price ?? 0) * $item->quantity;
        });
        
        // Determine overall delivery type
        if ($cartItems->contains('delivery_type', 'home_delivery')) {
            $deliveryType = 'home_delivery';
        } elseif ($cartItems->contains('delivery_type', 'takeaway')) {
            $deliveryType = 'takeaway';
        } else {
            $deliveryType = 'eat_in';
        }
    } else {
        // Get cart items from session for guests
        $sessionCart = session()->get('cart', []);
        $cartItems = collect($sessionCart)->map(function ($item, $menuItemId) {
            $menuItem = MenuItem::find($menuItemId);
            if (!$menuItem) return null;
            
            return (object) [
                'id' => $menuItemId,
                'menu_item_id' => $menuItemId,
                'quantity' => $item['quantity'],
                'delivery_type' => $item['delivery_type'] ?? 'eat_in',
                'menuItem' => $menuItem,
                'special_instructions' => $item['special_instructions'] ?? null,
                'options' => $item['options'] ?? []
            ];
        })->filter()->values();
        
        $cartCount = $cartItems->sum('quantity');
        $cartSubtotal = $cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });
        
        // Determine overall delivery type from session
        if ($cartItems->contains('delivery_type', 'home_delivery')) {
            $deliveryType = 'home_delivery';
        } elseif ($cartItems->contains('delivery_type', 'takeaway')) {
            $deliveryType = 'takeaway';
        } else {
            $deliveryType = 'eat_in';
        }
    }
    
    // Check for applied coupon
    if (session()->has('coupon')) {
        $appliedCoupon = session()->get('coupon');
        $coupon = Coupon::where('code', $appliedCoupon['code'])->first();
        
        if ($coupon && $coupon->isValid($cartSubtotal)) {
            $discountAmount = $coupon->calculateDiscount($cartSubtotal);
        } else {
            session()->forget('coupon');
            $appliedCoupon = null;
        }
    }
    
    // Calculate totals - DELIVERY FEE ONLY FOR HOME DELIVERY
    $taxRate = 0.075;
    $taxAmount = $cartSubtotal * $taxRate;
    $deliveryFee = ($deliveryType == 'home_delivery') ? 1500.00 : 0.00;
    $total = $cartSubtotal + $taxAmount + $deliveryFee - $discountAmount;
    
    return view('user.dashboard.cart', compact(
        'user',
        'cartItems',
        'cartSubtotal',
        'taxAmount',
        'deliveryFee',
        'discountAmount',
        'total',
        'cartCount',
        'appliedCoupon',
        'deliveryType'
    ));
}

    /**
     * Add item to cart (updated to handle menu orders)
     */
    public function addToCart(Request $request)
{
    $request->validate([
        'menu_item_id' => 'required|exists:menu_items,id',
        'quantity' => 'nullable|integer|min:1',
        'delivery_type' => 'required|in:eat_in,takeaway,home_delivery',
        'options' => 'nullable|array',
        'special_instructions' => 'nullable|string|max:500',
    ]);
    
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    $quantity = $request->quantity ?? 1;
    $menuItem = MenuItem::findOrFail($request->menu_item_id);
    
    if (!$menuItem->is_available) {
        return response()->json([
            'success' => false,
            'message' => 'This item is currently unavailable'
        ]);
    }
    
    if ($user) {
        // For logged-in users: save to database
        $cartItem = CartItem::where('user_id', $user->id)
                           ->where('menu_item_id', $request->menu_item_id)
                           ->first();
        
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->delivery_type = $request->delivery_type; // Save delivery type
            if ($request->has('special_instructions')) {
                $cartItem->special_instructions = $request->special_instructions;
            }
            if ($request->has('options')) {
                $cartItem->options = $request->options;
            }
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'menu_item_id' => $request->menu_item_id,
                'quantity' => $quantity,
                'delivery_type' => $request->delivery_type, // Save delivery type
                'options' => $request->options ?? [],
                'special_instructions' => $request->special_instructions ?? null,
            ]);
        }
        
        $cartCount = CartItem::where('user_id', $user->id)->sum('quantity');
    } else {
        // For guests: save to session
        $cart = session()->get('cart', []);
        $menuItemId = $request->menu_item_id;
        
        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] += $quantity;
        } else {
            $cart[$menuItemId] = [
                'name' => $menuItem->name,
                'quantity' => $quantity,
                'price' => $menuItem->price,
                'image' => $menuItem->image,
                'delivery_type' => $request->delivery_type, // Save delivery type
                'options' => $request->options ?? [],
                'special_instructions' => $request->special_instructions ?? null,
            ];
        }
        
        session()->put('cart', $cart);
        $cartCount = array_sum(array_column($cart, 'quantity'));
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Added to cart successfully!',
        'cart_count' => $cartCount
    ]);
}


    /**
     * Update cart item quantity
     */

    public function updateCart(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1|max:99',
            'special_instructions' => 'nullable|string|max:500',
        ]);
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $menuItemId = $request->menu_item_id;
        $quantity = $request->quantity;
        
        if ($user) {
            // For logged-in users: update in database
            $cartItem = CartItem::where('user_id', $user->id)
                               ->where('menu_item_id', $menuItemId)
                               ->first();
            
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                if ($request->has('special_instructions')) {
                    $cartItem->special_instructions = $request->special_instructions;
                }
                $cartItem->save();
            }
            
            $cartCount = CartItem::where('user_id', $user->id)->sum('quantity');
            $cartSubtotal = $this->calculateCartSubtotal($user);
        } else {
            // For guests: update in session
            $cart = session()->get('cart', []);
            
            if (isset($cart[$menuItemId])) {
                $cart[$menuItemId]['quantity'] = $quantity;
                if ($request->has('special_instructions')) {
                    $cart[$menuItemId]['special_instructions'] = $request->special_instructions;
                }
                
                session()->put('cart', $cart);
            }
            
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $cartSubtotal = $this->calculateCartSubtotal(null);
        }
        
        // Recalculate totals
        $taxRate = 0.075;
        $taxAmount = $cartSubtotal * $taxRate;
        $deliveryFee = $cartSubtotal > 0 ? 5.00 : 0;
        
        // Check for coupon discount
        $discountAmount = 0;
        if (session()->has('coupon')) {
            $appliedCoupon = session()->get('coupon');
            $coupon = Coupon::where('code', $appliedCoupon['code'])->first();
            if ($coupon && $coupon->isValid($cartSubtotal)) {
                $discountAmount = $coupon->calculateDiscount($cartSubtotal);
            }
        }
        
        $total = $cartSubtotal + $taxAmount + $deliveryFee - $discountAmount;
        
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $cartCount,
            'subtotal' => number_format($cartSubtotal, 2),
            'tax_amount' => number_format($taxAmount, 2),
            'delivery_fee' => number_format($deliveryFee, 2),
            'discount_amount' => number_format($discountAmount, 2),
            'total' => number_format($total, 2)
        ]);
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
        ]);
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $menuItemId = $request->menu_item_id;
        
        if ($user) {
            // For logged-in users: remove from database
            CartItem::where('user_id', $user->id)
                    ->where('menu_item_id', $menuItemId)
                    ->delete();
            
            $cartCount = CartItem::where('user_id', $user->id)->sum('quantity');
            $cartSubtotal = $this->calculateCartSubtotal($user);
        } else {
            // For guests: remove from session
            $cart = session()->get('cart', []);
            
            if (isset($cart[$menuItemId])) {
                unset($cart[$menuItemId]);
                session()->put('cart', $cart);
            }
            
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $cartSubtotal = $this->calculateCartSubtotal(null);
        }
        
        // Recalculate totals
        $taxRate = 0.075;
        $taxAmount = $cartSubtotal * $taxRate;
        $deliveryFee = $cartSubtotal > 0 ? 5.00 : 0;
        $total = $cartSubtotal + $taxAmount + $deliveryFee;
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $cartCount,
            'subtotal' => number_format($cartSubtotal, 2),
            'total' => number_format($total, 2)
        ]);
    }
    
    /**
     * Clear entire cart
     */
    public function clearCart(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        
        if ($user) {
            // For logged-in users: clear from database
            CartItem::where('user_id', $user->id)->delete();
        } else {
            // For guests: clear from session
            session()->forget('cart');
        }
        
        // Also clear any applied coupon
        session()->forget('coupon');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => 0
        ]);
    }
    
    /**
     * Apply promo code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $cartSubtotal = $this->calculateCartSubtotal($user);
        
        $coupon = Coupon::where('code', $request->coupon_code)
                        ->where('is_active', true)
                        ->whereDate('valid_from', '<=', now())
                        ->whereDate('valid_to', '>=', now())
                        ->first();
        
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        }
        
        if (!$coupon->isValid($cartSubtotal)) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon cannot be applied to this order'
            ]);
        }
        
        // Store coupon in session
        session()->put('coupon', [
            'code' => $coupon->code,
            'name' => $coupon->name,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
        ]);
        
        $discountAmount = $coupon->calculateDiscount($cartSubtotal);
        $taxRate = 0.075;
        $taxAmount = $cartSubtotal * $taxRate;
        $deliveryFee = $cartSubtotal > 0 ? 5.00 : 0;
        $total = $cartSubtotal + $taxAmount + $deliveryFee - $discountAmount;
        
        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'coupon_name' => $coupon->name,
            'discount_amount' => number_format($discountAmount, 2),
            'total' => number_format($total, 2)
        ]);
    }
    
    /**
     * Remove applied coupon
     */
    public function removeCoupon(Request $request)
    {
        session()->forget('coupon');
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $cartSubtotal = $this->calculateCartSubtotal($user);
        $taxRate = 0.075;
        $taxAmount = $cartSubtotal * $taxRate;
        $deliveryFee = $cartSubtotal > 0 ? 5.00 : 0;
        $total = $cartSubtotal + $taxAmount + $deliveryFee;
        
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed',
            'subtotal' => number_format($cartSubtotal, 2),
            'total' => number_format($total, 2)
        ]);
    }
    
    /**
     * Sync guest cart to user cart after login
     */
    public function syncGuestCart()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $sessionCart = session()->get('cart', []);
        
        if (!empty($sessionCart)) {
            foreach ($sessionCart as $menuItemId => $item) {
                $cartItem = CartItem::where('user_id', $user->id)
                                   ->where('menu_item_id', $menuItemId)
                                   ->first();
                
                if ($cartItem) {
                    $cartItem->quantity += $item['quantity'];
                    $cartItem->save();
                } else {
                    CartItem::create([
                        'user_id' => $user->id,
                        'menu_item_id' => $menuItemId,
                        'quantity' => $item['quantity'],
                        'options' => $item['options'] ?? [],
                        'special_instructions' => $item['special_instructions'] ?? null,
                    ]);
                }
            }
            
            // Clear session cart
            session()->forget('cart');
        }
        
        return redirect()->route('user.cart')
                         ->with('success', 'Cart synced successfully!');
    }
    
    /**
     * Helper method to calculate cart subtotal
     */
    private function calculateCartSubtotal($user = null)
    {
        if ($user) {
            return CartItem::where('user_id', $user->id)
                          ->with('menuItem')
                          ->get()
                          ->sum(function ($item) {
                              return ($item->menuItem->price ?? 0) * $item->quantity;
                          });
        } else {
            $cart = session()->get('cart', []);
            $subtotal = 0;
            
            foreach ($cart as $menuItemId => $item) {
                $menuItem = MenuItem::find($menuItemId);
                if ($menuItem) {
                    $subtotal += $menuItem->price * $item['quantity'];
                }
            }
            
            return $subtotal;
        }
    }
    
    /**
     * Handle reorder request - ADD ACTUAL ITEMS TO CART
     */
    public function reorder(Request $request, $orderId)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        $order = Order::where('user_id', $user->id)
                     ->with('items.menuItem')
                     ->findOrFail($orderId);
        
        $itemsAdded = 0;
        
        foreach ($order->items as $orderItem) {
            if ($orderItem->menuItem) {
                $request = new Request([
                    'menu_item_id' => $orderItem->menu_item_id,
                    'quantity' => $orderItem->quantity,
                ]);
                
                // Use addToCart method to handle both session and database
                $this->addToCart($request);
                $itemsAdded++;
            }
        }
        
        $cartCount = $user ? CartItem::where('user_id', $user->id)->sum('quantity') : 
                    (session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0);
        
        return response()->json([
            'success' => true,
            'message' => $itemsAdded . ' item(s) added to cart successfully!',
            'items_added' => $itemsAdded,
            'cart_count' => $cartCount
        ]);
    }
    
    /**
     * Get order items for reorder modal
     */
    public function getOrderItems($orderId)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        $order = Order::where('user_id', $user->id)
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
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
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
    public function removeFromWishlist(Request $request, $id = null)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            abort(403, 'User not authenticated');
        }
        
        // If ID is provided as parameter
        if ($id) {
            $wishlistItem = Wishlist::where('user_id', $user->id)
                                   ->where('menu_item_id', $id)
                                   ->first();
        } elseif ($request->filled('menu_item_id')) {
            // If ID is in request
            $request->validate([
                'menu_item_id' => 'required|exists:menu_items,id',
            ]);
            
            $wishlistItem = Wishlist::where('user_id', $user->id)
                                   ->where('menu_item_id', $request->menu_item_id)
                                   ->first();
        } elseif ($request->filled('wishlist_id')) {
            // If wishlist ID is provided
            $wishlistItem = Wishlist::where('user_id', $user->id)
                                   ->where('id', $request->wishlist_id)
                                   ->first();
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item ID not provided'
                ]);
            }
            return redirect()->route('user.wishlist')
                           ->with('error', 'Item ID not provided');
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
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
        
        // Add to cart using addToCart method
        $cartRequest = new Request([
            'menu_item_id' => $id,
            'quantity' => 1,
        ]);
        
        $cartResponse = $this->addToCart($cartRequest);
        
        // Remove from wishlist only if cart addition was successful
        if ($cartResponse->getData()->success) {
            $wishlistItem->delete();
            
            $wishlistCount = Wishlist::where('user_id', $user->id)->count();
            $cartCount = $user ? CartItem::where('user_id', $user->id)->sum('quantity') : 
                        (session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0);
            
            return response()->json([
                'success' => true,
                'message' => 'Added to cart and removed from wishlist',
                'wishlist_count' => $wishlistCount,
                'cart_count' => $cartCount
            ]);
        }
        
        return $cartResponse;
    }

    /**
     * Clear all wishlist items
     */
    public function clearWishlist(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            abort(403, 'User not authenticated');
        }
        
        Wishlist::where('user_id', $user->id)->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared',
                'wishlist_count' => 0
            ]);
        }
        
        return redirect()->route('user.wishlist')
                       ->with('success', 'Wishlist cleared successfully');
    }

    /**
     * Store new testimonial
     */
    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:20|max:1000',
            'designation' => 'nullable|string|max:100',
        ]);
        
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        
        // Check if user already has an approved testimonial
        $existingApproved = Testimonial::where('user_id', $user->id)
                                      ->orWhere('email', $user->email)
                                      ->where('is_approved', true)
                                      ->exists();
        
        if ($existingApproved) {
            return redirect()->route('user.reviews')
                           ->with('error', 'You already have an approved testimonial. Please contact admin if you want to update it.');
        }
        
        // Create testimonial
        Testimonial::create([
            'name' => $user->name,
            'email' => $user->email,
            'user_id' => $user->id,
            'designation' => $request->designation ?? 'Customer',
            'content' => $request->content,
            'rating' => $request->rating,
            'image' => $user->profile_image,
            'is_featured' => false,
            'is_approved' => false, // Needs admin approval
            'order' => 0,
        ]);
        
        return redirect()->route('user.reviews')
                       ->with('success', 'Thank you for your testimonial! It has been submitted for review.');
    }


    /**
 * Display checkout page
 */
public function checkout()
{
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    
    // Check if cart is empty
    $cartCount = 0;
    $cartItems = [];
    $cartSubtotal = 0;
    
    if ($user) {
        $cartItems = CartItem::where('user_id', $user->id)
                            ->with('menuItem')
                            ->get();
        $cartCount = $cartItems->sum('quantity');
        $cartSubtotal = $cartItems->sum(function ($item) {
            return ($item->menuItem->price ?? 0) * $item->quantity;
        });
    } else {
        $sessionCart = session()->get('cart', []);
        $cartItems = collect($sessionCart)->map(function ($item, $menuItemId) {
            $menuItem = MenuItem::find($menuItemId);
            if (!$menuItem) return null;
            
            return (object) [
                'id' => $menuItemId,
                'menu_item_id' => $menuItemId,
                'quantity' => $item['quantity'],
                'menuItem' => $menuItem,
                'special_instructions' => $item['special_instructions'] ?? null,
            ];
        })->filter()->values();
        
        $cartCount = $cartItems->sum('quantity');
        $cartSubtotal = $cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });
    }
    
    if ($cartCount == 0) {
        return redirect()->route('user.cart')
                         ->with('error', 'Your cart is empty. Please add items before checkout.');
    }
    
    // Calculate totals
    $taxRate = 0.075; // 7.5%
    $taxAmount = $cartSubtotal * $taxRate;
    $deliveryFee = $cartSubtotal > 0 ? 5.00 : 0;
    
    // Check for applied coupon
    $discountAmount = 0;
    $appliedCoupon = null;
    if (session()->has('coupon')) {
        $appliedCoupon = session()->get('coupon');
        $coupon = Coupon::where('code', $appliedCoupon['code'])->first();
        if ($coupon && $coupon->isValid($cartSubtotal)) {
            $discountAmount = $coupon->calculateDiscount($cartSubtotal);
        }
    }
    
    $total = $cartSubtotal + $taxAmount + $deliveryFee - $discountAmount;
    
    // Get user addresses
    $recentAddresses = Order::where('user_id', $user->id ?? 0)
                           ->whereNotNull('customer_address')
                           ->select('customer_address', 'customer_phone', 'customer_name')
                           ->distinct()
                           ->latest()
                           ->take(5)
                           ->get();
    
    // Get delivery instructions from session
    $deliveryInstructions = session()->get('delivery_instructions', '');
    
    return view('user.dashboard.checkout', compact(
        'user',
        'cartItems',
        'cartSubtotal',
        'taxAmount',
        'deliveryFee',
        'discountAmount',
        'total',
        'cartCount',
        'appliedCoupon',
        'recentAddresses',
        'deliveryInstructions'
    ));
}

/**
 * Process checkout
 */
public function processCheckout(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'required|string|max:20',
        'customer_email' => 'required|email|max:255',
        'customer_address' => 'required|string|max:500',
        'delivery_instructions' => 'nullable|string|max:1000',
        'payment_method' => 'required|in:card,transfer,cash',
    ]);
    
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    
    // Check if cart is empty
    $cartItems = [];
    $cartSubtotal = 0;
    $overallDeliveryType = 'eat_in'; // Default
    
    if ($user) {
        $cartItems = CartItem::where('user_id', $user->id)
                            ->with('menuItem')
                            ->get();
        $cartSubtotal = $cartItems->sum(function ($item) {
            return ($item->menuItem->price ?? 0) * $item->quantity;
        });
        
        // Determine order type from cart items
        if ($cartItems->contains('delivery_type', 'home_delivery')) {
            $overallDeliveryType = 'home_delivery';
        } elseif ($cartItems->contains('delivery_type', 'takeaway')) {
            $overallDeliveryType = 'takeaway';
        } else {
            $overallDeliveryType = 'eat_in';
        }
    } else {
        $sessionCart = session()->get('cart', []);
        $cartItems = collect($sessionCart)->map(function ($item, $menuItemId) {
            $menuItem = MenuItem::find($menuItemId);
            if (!$menuItem) return null;
            
            return (object) [
                'menu_item_id' => $menuItemId,
                'quantity' => $item['quantity'],
                'delivery_type' => $item['delivery_type'] ?? 'eat_in',
                'menuItem' => $menuItem,
            ];
        })->filter()->values();
        
        $cartSubtotal = $cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });
        
        // Determine order type from session
        if ($cartItems->contains('delivery_type', 'home_delivery')) {
            $overallDeliveryType = 'home_delivery';
        } elseif ($cartItems->contains('delivery_type', 'takeaway')) {
            $overallDeliveryType = 'takeaway';
        } else {
            $overallDeliveryType = 'eat_in';
        }
    }
    
    if (count($cartItems) == 0) {
        return response()->json([
            'success' => false,
            'message' => 'Your cart is empty'
        ]);
    }
    
    // Calculate totals - DELIVERY FEE ONLY FOR HOME DELIVERY
    $taxRate = 0.075;
    $taxAmount = $cartSubtotal * $taxRate;
    $deliveryFee = ($overallDeliveryType == 'home_delivery') ? 1500.00 : 0.00;
    
    // Check for applied coupon
    $discountAmount = 0;
    $couponId = null;
    if (session()->has('coupon')) {
        $appliedCoupon = session()->get('coupon');
        $coupon = Coupon::where('code', $appliedCoupon['code'])->first();
        if ($coupon && $coupon->isValid($cartSubtotal)) {
            $discountAmount = $coupon->calculateDiscount($cartSubtotal);
            $couponId = $coupon->id;
            
            // Increment coupon usage
            $coupon->increment('used_count');
        }
    }
    
    $totalAmount = $cartSubtotal + $taxAmount + $deliveryFee - $discountAmount;
    
    // Generate order reference
    $orderRef = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();
    
    // Create order - SAVE ORDER TYPE
    $orderData = [
        'order_ref' => $orderRef,
        'user_id' => $user->id ?? null,
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,
        'customer_phone' => $request->customer_phone,
        'customer_address' => $request->customer_address,
        'order_type' => $overallDeliveryType, // Save order type
        'order_status' => $request->payment_method == 'cash' ? 'pending' : 'pending_payment',
        'payment_status' => $request->payment_method == 'cash' ? 'pending' : 'pending',
        'payment_method' => $request->payment_method,
        'subtotal' => $cartSubtotal,
        'tax_amount' => $taxAmount,
        'delivery_fee' => $deliveryFee,
        'discount_amount' => $discountAmount,
        'total_amount' => $totalAmount,
        'delivery_instructions' => $request->delivery_instructions,
        'coupon_id' => $couponId,
    ];
    
    // For card payments, initiate Paystack payment
    if ($request->payment_method == 'card') {
        try {
            // Initialize Paystack
            $paystack = new \Yabacon\Paystack(env('PAYSTACK_SECRET_KEY'));
            
            $transactionData = [
                'email' => $request->customer_email,
                'amount' => $totalAmount * 100,
                'reference' => $orderRef,
                'callback_url' => route('user.checkout.verify-payment'),
                'metadata' => [
                    'order_ref' => $orderRef,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'order_type' => $overallDeliveryType,
                ]
            ];
            
            $transaction = $paystack->transaction->initialize($transactionData);
            
            // Save order with payment reference
            $orderData['payment_reference'] = $orderRef;
            $order = Order::create($orderData);
            
            // Add order items
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'menu_item_id' => $item->menu_item_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->menuItem->price,
                    'total_price' => $item->menuItem->price * $item->quantity,
                ]);
            }
            
            // Clear cart after order creation
            if ($user) {
                CartItem::where('user_id', $user->id)->delete();
            } else {
                session()->forget('cart');
            }
            
            // Clear coupon
            session()->forget('coupon');
            
            return response()->json([
                'success' => true,
                'payment_method' => 'card',
                'authorization_url' => $transaction->data->authorization_url,
                'access_code' => $transaction->data->access_code,
                'reference' => $transaction->data->reference,
                'order_ref' => $orderRef,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Paystack initialization error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Payment gateway error. Please try again.'
            ]);
        }
    } else {
        // For cash or transfer payments
        $order = Order::create($orderData);
        
        // Add order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'menu_item_id' => $item->menu_item_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->menuItem->price,
                'total_price' => $item->menuItem->price * $item->quantity,
            ]);
        }
        
        // Clear cart after order creation
        if ($user) {
            CartItem::where('user_id', $user->id)->delete();
        } else {
            session()->forget('cart');
        }
        
        // Clear coupon
        session()->forget('coupon');
        
        return response()->json([
            'success' => true,
            'payment_method' => $request->payment_method,
            'order_ref' => $orderRef,
            'redirect_url' => route('user.checkout.success'),
        ]);
    }
}











/**
 * Verify Paystack payment
 */
public function verifyPayment(Request $request)
{
    $reference = $request->reference;
    
    if (!$reference) {
        return redirect()->route('checkout.cancel')
                         ->with('error', 'Invalid payment reference');
    }
    
    try {
        // Verify payment with Paystack
        $paystack = new \Yabacon\Paystack(env('sk_test_3009a5ebcff695a9e8ea18b25270d9beaaa4cf6c'));
        $transaction = $paystack->transaction->verify(['reference' => $reference]);
        
        if ($transaction->data->status == 'success') {
            // Update order status
            $order = Order::where('payment_reference', $reference)->first();
            
            if ($order) {
                $order->update([
                    'order_status' => 'confirmed',
                    'payment_status' => 'paid',
                    'payment_date' => now(),
                    'transaction_id' => $transaction->data->id,
                ]);
                
                // Redirect to success page
                return redirect()->route('checkout.success')
                                 ->with('success', 'Payment successful! Your order has been confirmed.')
                                 ->with('order_ref', $order->order_ref);
            }
        }
        
        return redirect()->route('checkout.cancel')
                         ->with('error', 'Payment verification failed');
        
    } catch (\Exception $e) {
        Log::error('Paystack verification error: ' . $e->getMessage());
        
        return redirect()->route('checkout.cancel')
                         ->with('error', 'Payment verification error');
    }
}

/**
 * Display checkout success page
 */
public function checkoutSuccess()
{
    $orderRef = session('order_ref');
    $order = null;
    
    if ($orderRef) {
        $order = Order::where('order_ref', $orderRef)->first();
    }
    
    return view('user.dashboard.checkout-success', compact('order'));
}

/**
 * Display checkout cancel page
 */
public function checkoutCancel()
{
    return view('user.dashboard.checkout-cancel');
}

}