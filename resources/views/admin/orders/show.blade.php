@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
        <div class="btn-group">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <!-- Order Information -->
    <div class="row">
        <!-- Left Column - Order Details -->
        <div class="col-lg-8">
            <!-- Order Summary Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                            <p><strong>Order Date:</strong> {{ $order->getFormattedOrderDateAttribute() }}</p>
                            <p><strong>Order Type:</strong> 
                                <span class="badge {{ $order->order_type === 'delivery' ? 'bg-primary' : ($order->order_type === 'eat-in' ? 'bg-success' : 'bg-info') }}">
                                    {{ ucfirst($order->order_type) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Order Status:</strong>
                                <span class="badge {{ match($order->order_status) {
                                    'completed' => 'bg-success',
                                    'confirmed' => 'bg-info', 
                                    'preparing' => 'bg-primary',
                                    'ready' => 'bg-warning',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                } }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </p>
                            <p><strong>Payment Status:</strong>
                                <span class="badge {{ match($order->payment_status) {
                                    'paid' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'failed' => 'bg-danger',
                                    'refunded' => 'bg-info',
                                    default => 'bg-secondary'
                                } }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            <p><strong>Total Amount:</strong> {{ $order->getFormattedTotalAttribute() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Full Name:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($order->customer_address)
                                <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                            @endif
                            @if($order->table_number)
                                <p><strong>Table Number:</strong> {{ $order->table_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                @foreach($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->item_name }}</strong>
                                        @if($item->item_variant)
                                            <br><small class="text-muted">Variant: {{ $item->item_variant }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->getFormattedUnitPriceAttribute() }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><strong>{{ $item->getFormattedTotalPriceAttribute() }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Actions & Payment -->
        <div class="col-lg-4">
            <!-- Status Update Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="order_status" class="form-select">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->order_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="preparing" {{ $order->order_status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                <option value="ready" {{ $order->order_status === 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Order Status</button>
                    </form>

                    <form action="{{ route('admin.orders.update-payment-status', $order->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info w-100">Update Payment Status</button>
                    </form>
                </div>
            </div>

            <!-- Payment Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Information</h6>
                </div>
                <div class="card-body">
                    @if($order->payment_method)
                        <p><strong>Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                    @endif
                    @if($order->transaction_id)
                        <p><strong>Transaction ID:</strong> <code>{{ $order->transaction_id }}</code></p>
                    @endif
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₦{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->delivery_fee > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery Fee:</span>
                        <span>₦{{ number_format($order->delivery_fee, 2) }}</span>
                    </div>
                    @endif
                    @if($order->discount > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount:</span>
                        <span class="text-danger">-₦{{ number_format($order->discount, 2) }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Total Amount:</strong>
                        <strong>{{ $order->getFormattedTotalAttribute() }}</strong>
                    </div>
                </div>
            </div>

            <!-- Delete Order Card -->
            <div class="card shadow border-danger">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Danger Zone</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Once you delete this order, there is no going back. Please be certain.</p>
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete This Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection