@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-3">Checkout</h3>

    <!-- Order Summary -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-2">Order Summary</h5>

            <p><strong>Item:</strong> {{ $order['item_name'] }}</p>
            <p><strong>Qty:</strong> {{ $order['qty'] }}</p>
            <p><strong>Total:</strong> ₦{{ number_format($order['total']) }}</p>

            @if(!empty($order['addons']))
                <p><strong>Add-ons:</strong></p>
                <ul>
                    @foreach($order['addons'] as $a)
                        <li>{{ $a['name'] }} (₦{{ number_format($a['price']) }}) × {{ $a['qty'] }}</li>
                    @endforeach
                </ul>
            @endif

            @if(!empty($order['preferences']))
                <p><strong>Preferences:</strong> {{ implode(', ', $order['preferences']) }}</p>
            @endif

        </div>
    </div>

    <!-- Checkout Form -->
    <form method="POST" action="{{ route('checkout.submit') }}">
        @csrf

        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="fw-bold">Your Details</h5>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <hr>

                <h5 class="fw-bold">Order Type</h5>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="order_type" value="eat_in" checked>
                    <label class="form-check-label">Eat in the lounge</label>
                </div>

                <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="order_type" value="delivery">
                    <label class="form-check-label">Home Delivery</label>
                </div>

                <div id="deliveryAddressBox" class="mt-3" style="display:none;">
                    <label class="form-label">Delivery Address</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>

                <input type="hidden" name="order_payload" id="orderPayload">

                <button type="submit" class="btn btn-warning w-100 mt-4">Complete Order</button>

            </div>
        </div>

    </form>

</div>

<script>
document.querySelectorAll('input[name="order_type"]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.getElementById('deliveryAddressBox').style.display =
            radio.value === 'delivery' ? 'block' : 'none';
    });
});

// Encode clean WhatsApp message
let order = @json($order);

let message = `ORDER DETAILS\n\nItem: ${order.item_name}\nQty: ${order.qty}\nTotal: ₦${order.total}`;

if(order.addons){
    message += `\n\nAdd-ons:\n`;
    order.addons.forEach(a => {
        message += `- ${a.name} × ${a.qty} (₦${a.price})\n`;
    });
}

if(order.preferences){
    message += `\nPreferences: ${order.preferences.join(', ')}`;
}

document.getElementById('orderPayload').value = message;
</script>

@endsection
