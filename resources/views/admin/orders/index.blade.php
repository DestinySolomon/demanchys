@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Orders</h1>
        <div class="btn-group">
            <a href="{{ route('admin.orders.delivery') }}" class="btn btn-outline-primary">Delivery Orders</a>
            <a href="{{ route('admin.orders.eat-in') }}" class="btn btn-outline-success">Eat-in Orders</a>
            <a href="{{ route('admin.orders.takeaway') }}" class="btn btn-outline-info">Takeaway Orders</a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Orders ({{ $orders->total() }})</h6>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <strong>#{{ $order->order_number }}</strong>
                            </td>
                            <td>
                                {{ $order->getFormattedOrderDateAttribute() }}
                            </td>
                            <td>
                                <div>{{ $order->customer_name }}</div>
                                <small class="text-muted">{{ $order->customer_email }}</small>
                            </td>
                            <td>
                                <strong>{{ $order->getFormattedTotalAttribute() }}</strong>
                            </td>
                            <td>
                                @php
                                    $paymentBadge = match($order->payment_status) {
                                        'paid' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'failed' => 'bg-danger',
                                        'refunded' => 'bg-info',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $paymentBadge }}">{{ ucfirst($order->payment_status) }}</span>
                            </td>
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
                                @php
                                    $typeBadge = match($order->order_type) {
                                        'delivery' => 'bg-primary',
                                        'eat-in' => 'bg-success',
                                        'takeaway' => 'bg-info',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $typeBadge }}">{{ ucfirst($order->order_type) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="btn btn-sm btn-primary me-1" title="View Details">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <button class="btn btn-sm btn-danger delete-order" 
                                        data-id="{{ $order->id }}"
                                        data-number="{{ $order->order_number }}"
                                        title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No Orders Found</h4>
                <p class="text-muted">There are no orders in the system yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Order Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete order "<strong id="deleteOrderNumber"></strong>"?</p>
                <p class="text-danger small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    This action cannot be undone. All order items will be permanently deleted.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteOrderForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Order Modal
        document.querySelectorAll('.delete-order').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const orderNumber = this.getAttribute('data-number');
                
                document.getElementById('deleteOrderNumber').textContent = orderNumber;
                document.getElementById('deleteOrderForm').action = '{{ url('admin/orders') }}/' + id;
                
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteOrderModal'));
                deleteModal.show();
            });
        });
    });
</script>
@endpush

<style>
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
}
</style>
@endsection