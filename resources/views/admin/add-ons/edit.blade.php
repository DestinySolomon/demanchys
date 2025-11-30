@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Add-On</h1>
        <a href="{{ route('admin.add-ons.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Add-Ons
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Add-On Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.add-ons.update', $addOn->id) }}" method="POST" id="addOnForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Add-On Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Add-On Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $addOn->name) }}" 
                               required maxlength="255">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Price -->
                    <div class="col-md-6 mb-3">
                        <label for="additional_price" class="form-label">Additional Price (₦) *</label>
                        <input type="number" class="form-control @error('additional_price') is-invalid @enderror" 
                               id="additional_price" name="additional_price" 
                               value="{{ old('additional_price', $addOn->additional_price) }}" 
                               step="0.01" min="0" required>
                        @error('additional_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" 
                              maxlength="1000">{{ old('description', $addOn->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Sort Order -->
                    <div class="col-md-4 mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" 
                               value="{{ old('sort_order', $addOn->sort_order) }}" 
                               min="0" max="999">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Availability Toggle -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Availability</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_available" value="0">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_available" name="is_available" value="1"
                                   {{ old('is_available', $addOn->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                <span id="availabilityStatus">
                                    {{ $addOn->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </label>
                        </div>
                        @error('is_available')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Menu Items Selection -->
                <div class="mb-3">
                    <label class="form-label">Link to Menu Items (Optional)</label>
                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                        @foreach($menuItems as $menuItem)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   id="menu_item_{{ $menuItem->id }}" 
                                   name="menu_items[]" value="{{ $menuItem->id }}"
                                   {{ in_array($menuItem->id, old('menu_items', $addOn->menuItems->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="form-check-label" for="menu_item_{{ $menuItem->id }}">
                                {{ $menuItem->name }} - ₦{{ number_format($menuItem->price, 2) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Select menu items that this add-on can be added to</small>
                    @error('menu_items')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.add-ons.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Add-On
                    </button>
                </div>
            </form>

            <!-- Delete Form -->
            <div class="mt-4 pt-3 border-top">
                <form action="{{ route('admin.add-ons.destroy', $addOn->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this add-on? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Add-On
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const availabilityToggle = document.getElementById('is_available');
        const availabilityStatus = document.getElementById('availabilityStatus');
        
        if (availabilityToggle && availabilityStatus) {
            // Set initial status
            availabilityStatus.textContent = availabilityToggle.checked ? 'Available' : 'Unavailable';
            
            // Update on change
            availabilityToggle.addEventListener('change', function() {
                availabilityStatus.textContent = this.checked ? 'Available' : 'Unavailable';
            });
        }
    });
</script>
@endpush
@endsection