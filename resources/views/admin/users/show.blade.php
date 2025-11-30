@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0 text-gray-800">User Details</h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to Users
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Info & Stats Column -->
        <div class="col-lg-4 mb-4">
            <!-- User Info Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill text-dark fs-4"></i>
                        </div>
                    </div>
                    <h4 class="card-title">{{ $user->name }}</h4>
                    <p class="text-muted">Member since {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Order Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-primary mb-1">{{ $orderStats['active'] }}</h4>
                                <small class="text-muted">Active Orders</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-warning mb-1">{{ $orderStats['pending'] }}</h4>
                                <small class="text-muted">Pending Orders</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-success mb-1">{{ $orderStats['completed'] }}</h4>
                                <small class="text-muted">Completed Orders</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-danger mb-1">{{ $orderStats['cancelled'] }}</h4>
                                <small class="text-muted">Cancelled Orders</small>
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
                        <p class="mb-0">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div class="mb-3">
                        <strong><i class="bi bi-envelope me-2"></i>Email</strong>
                        <p class="mb-0">{{ $user->email }}</p>
                    </div>
                    <div class="mb-0">
                        <strong><i class="bi bi-geo-alt me-2"></i>Address</strong>
                        <p class="mb-0">{{ $user->address ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Delete User Button -->
            <div class="mt-4">
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their orders.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-2"></i> Delete User
                    </button>
                </form>
            </div>
        </div>

        <!-- Orders History Column -->
        <div class="col-lg-8">
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
                                <input type="text" class="form-control" placeholder="Search...">
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
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>#{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <div>
                                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </div>
                                        <small class="text-muted">State: {{ ucfirst($order->order_status) }}</small>
                                        <div>
                                            <small class="text-muted">Type: {{ $order->order_type }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-receipt display-1 text-muted d-block mb-2"></i>
                                        <h5 class="text-muted">No orders found</h5>
                                        <p class="text-muted">This user hasn't placed any orders yet.</p>
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
    </div>
</div>
@endsection