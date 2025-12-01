@extends('admin.layouts.app')

@section('title', 'Create Offer Deal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-tag me-2"></i>Create Offer Deal
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.offers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Offer Title *</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter offer title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Offer Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe your offer...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">Link URL <span class="text-muted">(Optional)</span></label>
                            <input type="url" class="form-control" id="url" name="url" value="{{ old('url') }}" placeholder="https://example.com/offer">
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Offer Image *</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <div class="form-text">Recommended size: 600x400px, Max size: 5MB</div>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active (Show on website)</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.banners.offers') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Create Offer
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
    document.getElementById('image').addEventListener('change', function() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '100%';
                img.style.maxHeight = '300px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection
@extends('admin.layouts.app')

@section('title', 'Create Offer Deal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-tag me-2"></i>Create Offer Deal
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.offers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Offer Title *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title') }}" placeholder="Enter offer title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Offer Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" placeholder="Describe your offer...">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="url" class="form-label">Link URL <span class="text-muted">(Optional)</span></label>
                            <input type="url" class="form-control" id="url" name="url" 
                                   value="{{ old('url') }}" placeholder="https://example.com/offer">
                            <div class="form-text">Link for customers to learn more or claim offer</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Offer Image *</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <div class="form-text">Recommended size: 600x400px, Max size: 5MB</div>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ old('start_date') }}">
                                <div class="form-text">When the offer becomes active</div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ old('end_date') }}">
                                <div class="form-text">When the offer expires</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active (Show on website)</label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.banners.offers') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Create Offer
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
                img.style.maxWidth = '100%';
                img.style.maxHeight = '300px';
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