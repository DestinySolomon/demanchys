@extends('admin.layouts.app')

@section('title', 'Create Promotional Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-megaphone me-2"></i>Create Promotional Banner
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.promotional.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Banner Title <span class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter banner title">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-muted">(Optional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter banner description">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">Link URL <span class="text-muted">(Optional)</span></label>
                            <input type="url" class="form-control" id="url" name="url" value="{{ old('url') }}" placeholder="https://example.com/page">
                            <div class="form-text">Where users will be redirected when clicking the banner</div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Banner Image *</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <div class="form-text">Recommended size: 1200x400px, Max size: 5MB</div>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date <span class="text-muted">(Optional)</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date <span class="text-muted">(Optional)</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active (Visible on website)</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.banners.promotional') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Create Banner
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
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection
