@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Eat-in Orders</h1>
        <div class="btn-group">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">All Orders</a>
            <a href="{{ route('admin.orders.delivery') }}" class="btn btn-outline-primary">Delivery Orders</a>
            <a href="{{ route('admin.orders.takeaway') }}" class="btn btn-outline-info">Takeaway Orders</a>
        </div>
    </div>

    <!-- Eat-in Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Eat-in Orders ({{ $orders->total() }})</h6>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Table Number</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->getFormattedOrderDateAttribute() }}</td>
                            <td>
                                <div>{{ $order->customer_name }}</div>
                                <small class="text-muted">{{ $order->customer_phone }}</small>
                            </td>
                            <td>
                                @if($order->table_number)
                                    <span class="badge bg-info">Table {{ $order->table_number }}</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>
                            <td><strong>{{ $order->getFormattedTotalAttribute() }}</strong></td>
                            <td>
                                @php
                                    $statusBadge = match($order->order_status) {
                                        'completed' => 'bg-success',
                                        'confirmed' => 'bg-info',
                                        'preparing' => 'bg-primary',
                                        'ready' => 'bg-warning',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusBadge }}">{{ ucfirst($order->order_status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="btn btn-sm btn-primary me-1">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-cup display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No Eat-in Orders</h4>
                <p class="text-muted">There are no eat-in orders at the moment.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection