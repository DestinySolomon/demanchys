<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        $orders = Order::with('items')
                      ->latest()
                      ->paginate(20);
            
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display delivery orders.
     */
    public function deliveryOrders()
    {
        $orders = Order::delivery()
                      ->with('items')
                      ->latest()
                      ->paginate(20);
            
        return view('admin.orders.delivery', compact('orders'));
    }

    /**
     * Display eat-in orders.
     */
    public function eatInOrders()
    {
        $orders = Order::eatIn()
                      ->with('items')
                      ->latest()
                      ->paginate(20);
            
        return view('admin.orders.eat-in', compact('orders'));
    }

    /**
     * Display takeaway orders.
     */
    public function takeawayOrders()
    {
        $orders = Order::takeaway()
                      ->with('items')
                      ->latest()
                      ->paginate(20);
            
        return view('admin.orders.takeaway', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['items.menuItem'])
                     ->findOrFail($id);
            
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'order_status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
        ]);

        $order->update([
            'order_status' => $validated['order_status'],
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update([
            'payment_status' => $validated['payment_status'],
        ]);

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Remove the specified order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')
                        ->with('success', 'Order deleted successfully!');
    }
}