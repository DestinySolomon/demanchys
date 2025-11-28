@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Menu Item</h1>
        <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Menu Items
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Item Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data" id="menuItemForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Item Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Item Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $menuItem->name) }}" 
                               required maxlength="255">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label for="menu_category_id" class="form-label">Category *</label>
                        <select class="form-control @error('menu_category_id') is-invalid @enderror" 
                                id="menu_category_id" name="menu_category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('menu_category_id', $menuItem->menu_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('menu_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" 
                              maxlength="1000">{{ old('description', $menuItem->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label">Price (₦) *</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', $menuItem->price) }}" 
                               step="0.01" min="0.01" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div class="col-md-4 mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" value="{{ old('sort_order', $menuItem->sort_order) }}" 
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

    <input class="form-check-input" 
           type="checkbox" 
           id="is_available" 
           name="is_available" 
           value="1"
           {{ old('is_available', $menuItem->is_available) ? 'checked' : '' }}>

    <label class="form-check-label" for="is_available">
        <span id="availabilityStatus">
            {{ $menuItem->is_available ? 'Available' : 'Unavailable' }}
        </span>
    </label>
</div>

                        @error('is_available')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Image -->
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Item Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($menuItem->image)
                            <div class="mt-2">
                                <label class="form-label">Current Image:</label>
                                <div>
                                    <img src="{{ Storage::disk('public')->url($menuItem->image) }}" 
                                         alt="{{ $menuItem->name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px; height: auto;"
                                         onerror="this.style.display='none'">
                                </div>
                                <small class="text-muted">Upload new image to replace current one</small>
                            </div>
                        @endif
                    </div>

                    <!-- Featured Toggle -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Featured Item</label>
                        <div class="form-check form-switch">
                      <input type="hidden" name="is_featured" value="0">

                       <input class="form-check-input" 
                      type="checkbox" 
                     id="is_featured" 
                     name="is_featured" 
                      value="1"
                          {{ old('is_featured', $menuItem->is_featured) ? 'checked' : '' }}>

                      <label class="form-check-label" for="is_featured">
                    <span id="featuredStatus">
                          {{ $menuItem->is_featured ? 'Featured' : 'Regular' }}
                          </span>
                       </label>
                       </div>

                        @error('is_featured')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Availability toggle
        const availabilityToggle = document.getElementById('is_available');
        const availabilityStatus = document.getElementById('availabilityStatus');

        // Update availability status text when the toggle changes

        
        if (availabilityToggle && availabilityStatus) {
            availabilityToggle.addEventListener('change', function() {
                availabilityStatus.textContent = this.checked ? 'Available' : 'Unavailable';
            });
        }


        

        // Featured toggle
        const featuredToggle = document.getElementById('is_featured');
        const featuredStatus = document.getElementById('featuredStatus');
        
        if (featuredToggle && featuredStatus) {
            featuredToggle.addEventListener('change', function() {
                featuredStatus.textContent = this.checked ? 'Featured' : 'Regular';
            });
        }
    });
</script>
@endpush
@endsection