@extends('admin.layouts.app')

@section('title', 'Add Testimonial')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-lg me-2"></i> Add New Testimonial
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name') }}" placeholder="John Doe" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="designation" class="form-label">Designation / Title</label>
                                    <input type="text" class="form-control" id="designation" name="designation" 
                                           value="{{ old('designation') }}" placeholder="e.g., Food Enthusiast, Regular Customer">
                                    @error('designation')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Testimonial Content *</label>
                            <textarea class="form-control" id="content" name="content" 
                                      rows="4" placeholder="What the customer said..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating (1-5 stars) *</label>
                                    <select class="form-select" id="rating" name="rating" required>
                                        <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>★★★★★ - Excellent (5)</option>
                                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>★★★★☆ - Very Good (4)</option>
                                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>★★★☆☆ - Good (3)</option>
                                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>★★☆☆☆ - Fair (2)</option>
                                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>★☆☆☆☆ - Poor (1)</option>
                                    </select>
                                    @error('rating')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="order" name="order" 
                                           value="{{ old('order') }}" placeholder="Lower numbers show first">
                                    <div class="form-text">Set display order (optional)</div>
                                    @error('order')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Customer Photo (Optional)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Recommended: Square image, max 2MB</div>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="mt-2" id="imagePreview"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                           {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="bi bi-star-fill text-warning"></i> Featured Testimonial
                                    </label>
                                    <div class="form-text">Show on homepage</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" value="1" checked>
                                    <label class="form-check-label" for="is_approved">
                                        <i class="bi bi-check-circle text-success"></i> Approved
                                    </label>
                                    <div class="form-text">Show on website</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Testimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';
                preview.appendChild(img);
                
                // Add image info
                const info = document.createElement('div');
                info.className = 'mt-2 text-muted small';
                info.textContent = `Selected: ${this.files[0].name} (${Math.round(this.files[0].size / 1024)} KB)`;
                preview.appendChild(info);
            }.bind(this);
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection