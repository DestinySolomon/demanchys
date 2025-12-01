@extends('admin.layouts.app')

@section('title', 'Edit ' . ucfirst($banner->type) . ' Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header {{ $banner->type === 'promotional' ? 'bg-primary' : 'bg-success' }} text-white">
                    <h5 class="mb-0">
                        <i class="bi {{ $banner->type === 'promotional' ? 'bi-megaphone' : 'bi-tag' }} me-2"></i>
                        Edit {{ ucfirst($banner->type) }} Banner
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ $banner->type === 'promotional' ? 'Banner Title' : 'Offer Title' }}</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $banner->title) }}" placeholder="Enter title">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $banner->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">Link URL</label>
                            <input type="url" class="form-control" id="url" name="url" value="{{ old('url', $banner->url) }}" placeholder="https://example.com">
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Current Image</label>
                            <div class="mb-3">
                                <img src="{{ Storage::url($banner->image_path) }}" alt="{{ $banner->title }}" class="img-thumbnail" style="max-width: 100%; max-height: 300px;">
                            </div>
                            <label for="image" class="form-label">Change Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Leave empty to keep current image.</div>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $banner->start_date?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $banner->end_date?->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ $banner->type === 'promotional' ? route('admin.banners.promotional') : route('admin.banners.offers') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
                            <button type="submit" class="btn {{ $banner->type === 'promotional' ? 'btn-primary' : 'btn-success' }}"><i class="bi bi-save me-1"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
@extends('admin.layouts.app')

@section('title', 'Edit ' . ucfirst($banner->type) . ' Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header {{ $banner->type === 'promotional' ? 'bg-primary' : 'bg-success' }} text-white">
                    <h5 class="mb-0">
                        <i class="bi {{ $banner->type === 'promotional' ? 'bi-megaphone' : 'bi-tag' }} me-2"></i>
                        Edit {{ ucfirst($banner->type) }} Banner
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                {{ $banner->type === 'promotional' ? 'Banner Title' : 'Offer Title' }}
                                @if($banner->type === 'offer')
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title', $banner->title) }}" 
                                   placeholder="Enter title"
                                   {{ $banner->type === 'offer' ? 'required' : '' }}>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" placeholder="Enter description">{{ old('description', $banner->description) }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="url" class="form-label">Link URL</label>
                            <input type="url" class="form-control" id="url" name="url" 
                                   value="{{ old('url', $banner->url) }}" placeholder="https://example.com">
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Current Image</label>
                            <div class="mb-3">
                                <img src="{{ Storage::url($banner->image_path) }}" 
                                     alt="{{ $banner->title }}"
                                     class="img-thumbnail"
                                     style="max-width: 100%; max-height: 300px;">
                            </div>
                            <label for="image" class="form-label">Change Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">
                                Leave empty to keep current image. 
                                {{ $banner->type === 'promotional' ? 'Recommended: 1200x400px' : 'Recommended: 600x400px' }}
                            </div>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="order" name="order" 
                                           value="{{ old('order', $banner->order) }}" min="0">
                                    <div class="form-text">Lower numbers appear first</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" 
                                               name="is_active" value="1" 
                                               {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active (Visible on website)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ old('start_date', $banner->start_date?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ old('end_date', $banner->end_date?->format('Y-m-d')) }}">
                            </div>
                        </div>
                        
                        @php
                            $backRoute = $banner->type === 'promotional' 
                                ? route('admin.banners.promotional')
                                : route('admin.banners.offers');
                        @endphp
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ $backRoute }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn {{ $banner->type === 'promotional' ? 'btn-primary' : 'btn-success' }}">
                                <i class="bi bi-save me-1"></i> Update
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
    // Image preview for new image
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
                info.textContent = `New image: ${this.files[0].name} (${Math.round(this.files[0].size / 1024)} KB)`;
                preview.appendChild(info);
            }.bind(this);
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection