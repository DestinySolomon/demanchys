@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add-Ons Management</h1>
        <a href="{{ route('admin.add-ons.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Add New Add-On
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Add-Ons Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Add-Ons ({{ $addOns->count() }})</h6>
        </div>
        <div class="card-body">
            @if($addOns->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="addOnsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Additional Price</th>
                            <th>Status</th>
                            <th>Linked Items</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($addOns as $addOn)
                        <tr>
                            <td>
                                <strong>{{ $addOn->name }}</strong>
                            </td>
                            <td>
                                @if($addOn->description)
                                    {{ Str::limit($addOn->description, 50) }}
                                @else
                                    <span class="text-muted">No description</span>
                                @endif
                            </td>
                            <td>
                                <strong>₦{{ number_format($addOn->additional_price, 2) }}</strong>
                            </td>
                            <td>
                                @if($addOn->is_available)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Unavailable</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $addOn->menuItems->count() }} items</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $addOn->sort_order }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.add-ons.edit', $addOn->id) }}" 
                                   class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-addon" 
                                        data-id="{{ $addOn->id }}"
                                        data-name="{{ $addOn->name }}"
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
                <h4 class="text-muted mt-3">No Add-Ons Found</h4>
                <p class="text-muted">Get started by creating your first add-on.</p>
                <a href="{{ route('admin.add-ons.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create First Add-On
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteAddOnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<strong id="deleteAddOnName"></strong>"?</p>
                <p class="text-danger small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    This action cannot be undone. This add-on will be removed from all menu items.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteAddOnForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Add-On
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Add-On Modal
        document.querySelectorAll('.delete-addon').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                document.getElementById('deleteAddOnName').textContent = name;
                document.getElementById('deleteAddOnForm').action = '{{ url('admin/add-ons') }}/' + id;
                
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteAddOnModal'));
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