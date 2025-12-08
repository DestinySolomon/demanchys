@extends('layouts.user-dashboard-clean')

@section('title', 'My Dashboard - Demanchys Lounge')

@section('content')
<div class="container-fluid">
    <!-- Welcome Message -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2 text-black">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-muted mb-0">Here's what's happening with your account today.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-inline-block px-3 py-2 rounded" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
                    <small class="text-white">Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Active Orders -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-cart-check fs-3" style="color: #ffc107;"></i>
                    </div>
                </div>
                <h3 class="mb-1 text-muted">{{ $orderStats['active'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Active Orders</p>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: rgba(13, 110, 253, 0.1);">
                        <i class="bi bi-bag fs-3" style="color: #0d6efd;"></i>
                    </div>
                </div>
                <h3 class="mb-1 text-muted">{{ $orderStats['total'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Total Orders</p>
            </div>
        </div>

        <!-- Upcoming Bookings -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: rgba(25, 135, 84, 0.1);">
                        <i class="bi bi-calendar-check fs-3" style="color: #198754;"></i>
                    </div>
                </div>
                <h3 class="mb-1 text-muted">{{ $bookingStats['upcoming'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Upcoming Bookings</p>
            </div>
        </div>

        <!-- Wishlist Items -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: rgba(220, 53, 69, 0.1);">
                        <i class="bi bi-heart fs-3" style="color: #dc3545;"></i>
                    </div>
                </div>
                <h3 class="mb-1 text-muted">{{ $wishlistCount ?? 0 }}</h3>
                <p class="text-muted mb-0">Wishlist Items</p>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Quick Actions -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Recent Orders</h3>
                    <a href="{{ route('user.orders') }}" class="btn btn-sm btn-warning">View All</a>
                </div>
                
                @if(isset($recentOrders) && $recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ $order->total_items ?? 1 }}</td>
                                    <td>₦{{ number_format($order->total_amount) }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $order->order_status == 'completed' ? 'success' : 
                                            ($order->order_status == 'processing' ? 'warning' : 
                                            ($order->order_status == 'pending' ? 'info' : 'secondary')) 
                                        }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            @if($order->order_status == 'completed')
                                                <button class="btn btn-sm btn-warning reorder-btn" 
                                                        data-order-id="{{ $order->id }}">
                                                    Reorder
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                        <p class="text-muted mt-3">No orders yet</p>
                        <a href="{{ route('menu') }}" class="btn btn-warning">Start Shopping</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card h-100">
                <h3 class="mb-4">Quick Actions</h3>
                
                <div class="list-group list-group-flush">
                    <a href="{{ route('menu') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background: rgba(255, 193, 7, 0.1);">
                            <i class="bi bi-plus-circle" style="color: #ffc107;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Place New Order</h6>
                            <small class="text-muted">Browse our menu</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.bookings') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background: rgba(25, 135, 84, 0.1);">
                            <i class="bi bi-calendar-plus" style="color: #198754;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Book a Table</h6>
                            <small class="text-muted">Reserve your spot</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.wishlist') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background: rgba(220, 53, 69, 0.1);">
                            <i class="bi bi-heart" style="color: #dc3545;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">View Wishlist</h6>
                            <small class="text-muted">{{ $wishlistCount ?? 0 }} items saved</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.edit-profile') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background: rgba(13, 110, 253, 0.1);">
                            <i class="bi bi-person-circle" style="color: #0d6efd;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Update Profile</h6>
                            <small class="text-muted">Keep your info current</small>
                        </div>
                    </a>
                </div>
                
                <!-- Recent Activity - REAL DATA ONLY -->
                <div class="mt-5">
                    <h6 class="mb-3">Recent Activity</h6>
                    <div class="list-group list-group-flush">
                        @php
                            // Collect real activities from database
                            $activities = collect();
                            
                            // Add real order activities
                            if(isset($recentOrders) && $recentOrders->count() > 0) {
                                foreach($recentOrders as $order) {
                                    $activities->push([
                                        'date' => $order->created_at,
                                        'message' => "Order #{$order->id} placed - ₦" . number_format($order->total_amount),
                                        'type' => 'order'
                                    ]);
                                }
                            }
                            
                            // Add real booking activities
                            if(isset($upcomingBookings) && $upcomingBookings->count() > 0) {
                                foreach($upcomingBookings as $booking) {
                                    $activities->push([
                                        'date' => $booking->created_at,
                                        'message' => "Booking for " . \Carbon\Carbon::parse($booking->date)->format('M d') . " - {$booking->guests} guests",
                                        'type' => 'booking'
                                    ]);
                                }
                            }
                            
                            // Sort by date and take latest 3
                            $recentActivities = $activities->sortByDesc('date')->take(3);
                        @endphp
                        
                        @if($recentActivities->count() > 0)
                            @foreach($recentActivities as $activity)
                                <div class="list-group-item px-0 py-2 border-0">
                                    <small class="text-muted">{{ $activity['date']->diffForHumans() }}</small>
                                    <p class="mb-1">{{ $activity['message'] }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="list-group-item px-0 py-2 border-0">
                                <small class="text-muted">No recent activity</small>
                                <p class="mb-1 text-muted">Your activity will appear here</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Bookings - Only show if there are real bookings -->
    @if(isset($upcomingBookings) && $upcomingBookings->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Upcoming Bookings</h3>
                    <a href="{{ route('user.bookings') }}" class="btn btn-sm btn-warning">View All</a>
                </div>
                
                <div class="row">
                    @foreach($upcomingBookings as $booking)
                    <div class="col-md-4 mb-3">
                        <div class="card border h-100">
                            <div class="card-body">
                                <h6 class="card-title">{{ $booking->event_title ?? 'Table Reservation' }}</h6>
                                <p class="card-text small text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}
                                </p>
                                <p class="card-text small">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $booking->time }}
                                </p>
                                <p class="card-text small">
                                    <i class="bi bi-people me-1"></i>
                                    {{ $booking->guests }} guests
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <a href="{{ route('user.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Reorder Modal -->
<div class="modal fade" id="reorderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reorder Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Add all items from this order to your cart?</p>
                <div id="reorderItemsList"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmReorder">Add to Cart</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reorder functionality
        const reorderButtons = document.querySelectorAll('.reorder-btn');
        const reorderModal = new bootstrap.Modal(document.getElementById('reorderModal'));
        let currentOrderId = null;

        reorderButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentOrderId = this.getAttribute('data-order-id');
                
                // Show loading state
                document.getElementById('reorderItemsList').innerHTML = `
                    <div class="text-center">
                        <div class="spinner-border spinner-border-sm text-warning"></div>
                        <p class="mt-2">Loading order items...</p>
                    </div>
                `;
                
                // Fetch order items
                fetch(`/my-account/orders/${currentOrderId}/items`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.items && data.items.length > 0) {
                            let itemsHtml = '<ul class="list-group mb-3">';
                            data.items.forEach(item => {
                                itemsHtml += `
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>${item.name}</span>
                                        <span>${item.quantity} × ₦${item.price}</span>
                                    </li>
                                `;
                            });
                            itemsHtml += '</ul>';
                            document.getElementById('reorderItemsList').innerHTML = itemsHtml;
                        } else {
                            document.getElementById('reorderItemsList').innerHTML = 
                                '<p class="text-muted">No items found in this order.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('reorderItemsList').innerHTML = 
                            '<p class="text-danger">Error loading order items.</p>';
                    });
                
                reorderModal.show();
            });
        });

        // Confirm reorder
        document.getElementById('confirmReorder').addEventListener('click', function() {
            if (!currentOrderId) return;

            const button = this;
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Adding...';
            button.disabled = true;

            fetch(`/my-account/reorder/${currentOrderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in navbar
                    const cartCountElements = document.querySelectorAll('.badge-count');
                    cartCountElements.forEach(el => {
                        const currentCount = parseInt(el.textContent) || 0;
                        el.textContent = currentCount + data.items_added;
                    });
                    
                    // Show success message
                    alert('Items added to cart successfully!');
                    reorderModal.hide();
                } else {
                    alert(data.message || 'Error adding items to cart.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    });
</script>
@endpush

<style>
    .list-group-item {
        border: none;
        padding-left: 0;
        padding-right: 0;
    }
    
    .list-group-item:not(:last-child) {
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    
    .table th {
        border-top: none;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
    }
    
    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
    }
    
    .card {
        border: 1px solid #eaeaea;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
</style>
@endsection