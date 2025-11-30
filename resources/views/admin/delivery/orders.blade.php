@extends('admin.layouts.app')

@section('title', 'Delivery Man Orders')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-0 text-gray-800">All Orders - {{ $deliveryMan->name }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.delivery.index') }}">Delivery Men</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.delivery.show', $deliveryMan->id) }}">{{ $deliveryMan->name }}</a></li>
                            <li class="breadcrumb-item active">All Orders</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.delivery.show', $deliveryMan->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to Details
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0">All Orders</h6>
            <div class="d-flex align-items-center">
                <label class="me-2 mb-0">Show</label>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <label class="ms-2 mb-0">entries</label>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Box -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search orders...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Customer</th>
                            <th>Order Id</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Order Status</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($order->user)
                                    {{ $order->user->name }}
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif
                            </td>
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <div>
                                    <span class="badge bg-{{ $order->order_status == 'completed' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                                <small class="text-muted">Type: {{ $order->order_type }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.delivery.order-details', ['deliveryId' => $deliveryMan->id, 'orderId' => $order->id]) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-receipt display-1 text-muted d-block mb-2"></i>
                                <h5 class="text-muted">No orders found</h5>
                                <p class="text-muted">This delivery man hasn't been assigned any orders yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                </div>
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection