@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Menu Items Management</h1>
        <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Add New Item
                </a>
            </div>

            <!-- Menu Items Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Menu Items ({{ $menuItems->count() }})</h6>
        </div>
        <div class="card-body">
            @if($menuItems->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="menuItemsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menuItems as $item)
                        <tr>


                          <td class="text-center">
                      @if($item->image)
                        <img src="{{ Storage::disk('public')->url($item->image) }}"
                            alt="{{ $item->name }}"
                            class="rounded"
                            style="width: 50px; height: 50px; object-fit: cover;"
                            onerror="this.onerror=null; this.src='{{ asset('assets/placeholder_food.jpg') }}'">
                      @else
                        <img src="{{ asset('assets/placeholder_food.jpg') }}"
                            alt="placeholder"
                            class="rounded bg-light d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px; object-fit: cover;">
                      @endif
                       </td>
                       
                            <td>
                                <strong>{{ $item->name }}</strong>
                                @if($item->description)
                                    <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->category->name }}</span>
                            </td>
                            <td>
                                <strong>₦{{ number_format($item->price, 2) }}</strong>
                            </td>

                            <td class="text-center">
                                @if($item->is_available)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Unavailable</span>
                                @endif
                            </td>


    
                            <td>
                                @if($item->is_featured)
                                    <span class="badge bg-warning text-dark">Featured</span>
                                @else
                                    <span class="badge bg-light text-muted">Regular</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $item->sort_order }}</span>
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.menu-items.edit', $item->id) }}" 
                                   class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-item" 
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No Menu Items Found</h4>
                <p class="text-muted">Get started by creating your first menu item.</p>
                <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create First Item
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<strong id="deleteItemName"></strong>"?</p>
                <p class="text-danger small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    This action cannot be undone. This item will be removed from all orders.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteItemForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>











@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Item Modal
        document.querySelectorAll('.delete-item').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                document.getElementById('deleteItemName').textContent = name;
                document.getElementById('deleteItemForm').action = '{{ url('admin/menu-items') }}/' + id;
                
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteItemModal'));
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