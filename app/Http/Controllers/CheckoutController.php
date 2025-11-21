<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        // Validate incoming order payload
        $data = $request->validate([
            'item_name' => 'required|string',
            'qty' => 'required|integer',
            'total' => 'required',
            'addons' => 'nullable|array',
            'preferences' => 'nullable|array'
        ]);

        return view('checkout', ['order' => $data]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'phone' => 'required|string',
            'order_type' => 'required|in:eat_in,delivery',
            'address' => 'nullable|string',
            'order_payload' => 'required',
        ]);

        // Process or redirect
        $whatsAppNumber = '2347087766823'; // Replace with your WhatsApp number

        $text = urlencode($validated['order_payload']);

        return redirect("https://wa.me/$whatsAppNumber?text=$text");
    }
}
