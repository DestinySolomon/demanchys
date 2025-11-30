@extends('admin.layouts.app')

@section('title', 'Delivery Man Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0 text-gray-800">Delivery Man Details</h2>
                <a href="{{ route('admin.delivery.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Delivery Man Info & Stats Column -->
        <div class="col-lg-4 mb-4">
            <!-- Delivery Man Info Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($deliveryMan->avatar)
                            <img src="{{ asset('storage/' . $deliveryMan->avatar) }}" 
                                 alt="{{ $deliveryMan->name }}" 
                                 class="rounded-circle border" 
                                 width="100" height="100" style="object-fit: cover;">
                        @else
                            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="bi bi-truck text-dark fs-2"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="card-title">{{ $deliveryMan->name }}</h4>
                    <p class="text-muted">
                        <span class="badge bg-{{ $deliveryMan->status == 'active' ? 'success' : 'secondary' }} me-2">
                            {{ ucfirst($deliveryMan->status) }}
                        </span>
                        <span class="badge bg-info text-dark text-capitalize">
                            {{ $deliveryMan->gender }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Earnings Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Earnings Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-primary mb-1">${{ number_format($deliveryMan->total_earnings, 2) }}</h4>
                                <small class="text-muted">Total Earnings</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-warning mb-1">${{ number_format($deliveryMan->commission_deducted, 2) }}</h4>
                                <small class="text-muted">Commission Deducted</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-success mb-1">${{ number_format($deliveryMan->net_earnings, 2) }}</h4>
                                <small class="text-muted">Net Earnings</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-info mb-1">${{ number_format($deliveryMan->available_balance, 2) }}</h4>
                                <small class="text-muted">Available Balance</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-secondary mb-1">${{ number_format($deliveryMan->total_withdrawn, 2) }}</h4>
                                <small class="text-muted">Total Withdraw</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-danger mb-1">${{ number_format($deliveryMan->pending_withdrawal, 2) }}</h4>
                                <small class="text-muted">Pending Withdraw</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="bi bi-telephone me-2"></i>Phone</strong>
                        <p class="mb-0">{{ $deliveryMan->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <strong><i class="bi bi-envelope me-2"></i>Email</strong>
                        <p class="mb-0">{{ $deliveryMan->email }}</p>
                    </div>
                    @if($deliveryMan->address)
                    <div class="mb-3">
                        <strong><i class="bi bi-geo-alt me-2"></i>Address</strong>
                        <p class="mb-0">{{ $deliveryMan->address }}</p>
                    </div>
                    @endif
                    @if($deliveryMan->vehicle_type)
                    <div class="mb-3">
                        <strong><i class="bi bi-truck me-2"></i>Vehicle</strong>
                        <p class="mb-0">{{ $deliveryMan->vehicle_type }} - {{ $deliveryMan->vehicle_number }}</p>
                    </div>
                    @endif
                    <div class="mb-0">
                        <strong><i class="bi bi-clock me-2"></i>Last Active</strong>
                        <p class="mb-0">{{ $deliveryMan->last_active ? $deliveryMan->last_active->format('M d, Y H:i') : 'Never' }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.delivery.orders', $deliveryMan->id) }}" class="btn btn-warning">
                        <i class="bi bi-list-ul me-2"></i> View All Orders
                    </a>
                    <form action="{{ route('admin.delivery.destroy', $deliveryMan->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this delivery man?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i> Delete Delivery Man
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Statistics Column -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Order Statistics</h6>
                    <span class="badge bg-primary">Commission Rate: {{ $deliveryMan->commission_rate }}%</span>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 bg-primary text-white">
                                <h3 class="mb-1">{{ $deliveryMan->active_orders_count }}</h3>
                                <small>Active Orders</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 bg-warning text-dark">
                                <h3 class="mb-1">{{ $deliveryMan->orders->where('order_status', 'pending')->count() }}</h3>
                                <small>Pending Orders</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 bg-success text-white">
                                <h3 class="mb-1">{{ $deliveryMan->completed_orders_count }}</h3>
                                <small>Completed Orders</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 bg-danger text-white">
                                <h3 class="mb-1">{{ $deliveryMan->orders->where('order_status', 'cancelled')->count() }}</h3>
                                <small>Cancelled Orders</small>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="mt-4">
                        <h6 class="mb-3">Recent Orders</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($deliveryMan->orders->take(5) as $order)
                                    <tr>
                                        <td>#{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->order_status == 'completed' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.delivery.order-details', ['deliveryId' => $deliveryMan->id, 'orderId' => $order->id]) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            No orders assigned yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($deliveryMan->orders->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.delivery.orders', $deliveryMan->id) }}" class="btn btn-sm btn-outline-dark">
                                View All Orders ({{ $deliveryMan->orders->count() }})
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection