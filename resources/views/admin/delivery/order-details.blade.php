@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-0 text-gray-800">Order Details</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.delivery.index') }}">Delivery Men</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.delivery.show', $deliveryMan->id) }}">{{ $deliveryMan->name }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.delivery.orders', $deliveryMan->id) }}">Orders</a></li>
                            <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.delivery.orders', $deliveryMan->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Order Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="40%">Order Date:</th>
                                    <td>{{ $order->created_at->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Order Type:</th>
                                    <td>{{ ucfirst($order->order_type) }}</td>
                                </tr>
                                <tr>
                                    <th>Order Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $order->order_status == 'completed' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="40%">Payment Method:</th>
                                    <td>{{ ucfirst($order->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($order->transaction_id)
                                <tr>
                                    <th>Transaction ID:</th>
                                    <td><code>{{ $order->transaction_id }}</code></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Order Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- This would loop through order items -->
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <strong>Fried chicken wings and fish</strong>
                                        <div class="text-muted small">Size: Small</div>
                                    </td>
                                    <td>$40.00</td>
                                    <td>1</td>
                                    <td>$50.00</td>
                                </tr>
                                <!-- Add more items as needed -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                    <td><strong>$50.00</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">Discount:</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">Delivery Charge:</td>
                                    <td>$10.58</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>$60.58</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Delivery Information -->
        <div class="col-lg-4">
            <!-- Billing Address -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Billing Address</h6>
                </div>
                <div class="card-body">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}<br>
                    <div class="mt-2">
                        {{ $order->customer_address }}
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Shipping Information</h6>
                </div>
                <div class="card-body">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}<br>
                    <div class="mt-2">
                        {{ $order->customer_address }}
                    </div>
                    <hr>
                    <div class="small">
                        <strong>Shipping Type:</strong> Fixed Shipping<br>
                        <strong>Delivery Status:</strong> 
                        <span class="badge bg-success">Delivered</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection