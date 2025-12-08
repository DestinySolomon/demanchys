@extends('layouts.user-dashboard-clean')

@section('title', 'My Orders - Demanchys Lounge')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-2 text-muted">My Orders</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Orders</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('menu') }}" class="btn btn-warning">
                        <i class="bi bi-plus-circle me-1"></i> New Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(13, 110, 253, 0.1);">
                        <i class="bi bi-bag fs-4" style="color: #0d6efd;"></i>
                    </div>
                </div>
                <h4 class="mb-1">{{ $orderStats['total'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Total Orders</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-clock-history fs-4" style="color: #ffc107;"></i>
                    </div>
                </div>
                <h4 class="mb-1">{{ $orderStats['active'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Active</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(25, 135, 84, 0.1);">
                        <i class="bi bi-check-circle fs-4" style="color: #198754;"></i>
                    </div>
                </div>
                <h4 class="mb-1">{{ $orderStats['completed'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Completed</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(220, 53, 69, 0.1);">
                        <i class="bi bi-x-circle fs-4" style="color: #dc3545;"></i>
                    </div>
                </div>
                <h4 class="mb-1">{{ $orderStats['cancelled'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Cancelled</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="dashboard-card mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="statusFilter" class="form-label fw-medium">Filter by Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="all">All Orders</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="dateFilter" class="form-label fw-medium">Filter by Date</label>
                <select class="form-select" id="dateFilter">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="searchOrders" class="form-label fw-medium">Search Orders</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchOrders" placeholder="Search by Order ID...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Order History</h4>
            <div class="text-muted">
                Showing {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
            </div>
        </div>

        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="order-row" data-status="{{ $order->order_status }}">
                            <td>
                                <strong>#{{ $order->id }}</strong>
                                <div class="small text-muted">{{ $order->order_number }}</div>
                            </td>
                            <td>
                                {{ $order->created_at->format('M d, Y') }}
                                <div class="small text-muted">{{ $order->created_at->format('h:i A') }}</div>
                            </td>
                            <td>
                                {{ $order->total_items ?? 1 }} item(s)
                                <div class="small text-muted">
                                    @if($order->items->count() > 0)
                                        {{ $order->items->first()->menuItem->name ?? 'Item' }}
                                        @if($order->items->count() > 1)
                                            +{{ $order->items->count() - 1 }} more
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong>₦{{ number_format($order->total_amount) }}</strong>
                                <div class="small text-muted">
                                    @if($order->order_type)
                                        {{ ucfirst($order->order_type) }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge order-status-badge bg-{{ 
                                    $order->order_status == 'completed' ? 'success' : 
                                    ($order->order_status == 'processing' ? 'warning' : 
                                    ($order->order_status == 'confirmed' ? 'info' : 
                                    ($order->order_status == 'pending' ? 'secondary' : 'danger'))) 
                                }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                                @if($order->payment_status)
                                    <div class="small mt-1">
                                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    @if($order->order_status == 'completed')
                                        <button class="btn btn-sm btn-warning reorder-btn" data-order-id="{{ $order->id }}">
                                            <i class="bi bi-arrow-repeat"></i> Reorder
                                        </button>
                                    @endif
                                    @if(in_array($order->order_status, ['pending', 'processing']))
                                        <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}" 
                                              onsubmit="return confirm('Are you sure you want to cancel this order?');"
                                              class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-circle"></i> Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}
                </div>
                <nav aria-label="Order pagination">
                    <ul class="pagination mb-0">
                        {{-- Previous Page Link --}}
                        @if($orders->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach(range(1, $orders->lastPage()) as $page)
                            @if($page == $orders->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @elseif($page >= $orders->currentPage() - 2 && $page <= $orders->currentPage() + 2)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orders->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if($orders->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        @else
            <!-- No Orders -->
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Orders Yet</h4>
                <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                <a href="{{ route('menu') }}" class="btn btn-warning">
                    <i class="bi bi-menu-button me-1"></i> Browse Menu
                </a>
            </div>
        @endif
    </div>

    <!-- Order Status Legend -->
    <div class="dashboard-card mt-4">
        <h5 class="mb-3">Order Status Guide</h5>
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <span class="badge bg-secondary me-2">Pending</span>
                    <small class="text-muted">Order received, not processed</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <span class="badge bg-info me-2">Confirmed</span>
                    <small class="text-muted">Order confirmed by restaurant</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <span class="badge bg-warning me-2">Processing</span>
                    <small class="text-muted">Being prepared</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <span class="badge bg-success me-2">Completed</span>
                    <small class="text-muted">Delivered/Ready for pickup</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reorder Modal (Same as dashboard) -->
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
        // Filter functionality
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const searchInput = document.getElementById('searchOrders');
        const orderRows = document.querySelectorAll('.order-row');

        function filterOrders() {
            const status = statusFilter.value;
            const searchTerm = searchInput.value.toLowerCase();
            
            orderRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                const orderId = row.querySelector('strong').textContent.toLowerCase();
                const orderNumber = row.querySelector('.small.text-muted')?.textContent.toLowerCase() || '';
                
                const statusMatch = status === 'all' || rowStatus === status;
                const searchMatch = !searchTerm || 
                    orderId.includes(searchTerm) || 
                    orderNumber.includes(searchTerm);
                
                row.style.display = (statusMatch && searchMatch) ? '' : 'none';
            });
        }

        if (statusFilter) statusFilter.addEventListener('change', filterOrders);
        if (searchInput) searchInput.addEventListener('input', filterOrders);
        if (dateFilter) dateFilter.addEventListener('change', filterOrders);

        // Reorder functionality (same as dashboard)
        const reorderButtons = document.querySelectorAll('.reorder-btn');
        const reorderModal = new bootstrap.Modal(document.getElementById('reorderModal'));
        let currentOrderId = null;

        reorderButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentOrderId = this.getAttribute('data-order-id');
                
                document.getElementById('reorderItemsList').innerHTML = `
                    <div class="text-center">
                        <div class="spinner-border spinner-border-sm text-warning"></div>
                        <p class="mt-2">Loading order items...</p>
                    </div>
                `;
                
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
    .order-status-badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
        min-width: 85px;
        display: inline-block;
        text-align: center;
    }
    
    .table th {
        border-top: none;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        background: #f8f9fa;
    }
    
    .table tbody tr {
        transition: all 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: rgba(255, 193, 7, 0.05);
    }
    
    .page-link {
        color: #495057;
        border-color: #dee2e6;
    }
    
    .page-link:hover {
        color: #000;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .page-item.active .page-link {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #000;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
</style>
@endsection