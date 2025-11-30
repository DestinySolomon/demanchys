<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryMen = DeliveryMan::orderBy('created_at', 'desc')->get();
        return view('admin.delivery.index', compact('deliveryMen'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deliveryMan = DeliveryMan::with(['orders' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admin.delivery.show', compact('deliveryMan'));
    }

    /**
     * Show delivery man's orders
     */
    public function orders(string $id)
    {
        $deliveryMan = DeliveryMan::findOrFail($id);
        $orders = $deliveryMan->orders()->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.delivery.orders', compact('deliveryMan', 'orders'));
    }

    /**
     * Show order details
     */
    public function orderDetails(string $deliveryId, string $orderId)
    {
        $deliveryMan = DeliveryMan::findOrFail($deliveryId);
        $order = Order::with(['user', 'orderItems'])->findOrFail($orderId);

        return view('admin.delivery.order-details', compact('deliveryMan', 'order'));
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deliveryMan = DeliveryMan::findOrFail($id);
        
        // Remove delivery man from orders before deleting
        Order::where('delivery_person_id', $id)->update(['delivery_person_id' => null]);
        
        $deliveryMan->delete();

        return redirect()->route('admin.delivery.index')->with('success', 'Delivery man deleted successfully!');
    }

    // // We don't need these for now
    // public function create() { abort(404); }
    // public function store(Request $request) { abort(404); }
    public function edit(string $id) { abort(404); }
    public function update(Request $request, string $id) { abort(404); }



    
}