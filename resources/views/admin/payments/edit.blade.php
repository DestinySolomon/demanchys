@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Configure Payment Method</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payment Methods</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Configure {{ $paymentMethod->name }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('admin.payments.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Payment Method Header -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="{{ $paymentMethod->icon }} fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1">{{ $paymentMethod->name }}</h4>
                                    <p class="text-muted mb-0">{{ $paymentMethod->description }}</p>
                                </div>
                            </div>
                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $paymentMethod->type)) }}</span>
                        </div>

                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Display Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" 
                                           value="{{ old('name', $paymentMethod->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" 
                                           value="{{ old('sort_order', $paymentMethod->sort_order) }}">
                                    <div class="form-text">Lower numbers appear first</div>
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="2">{{ old('description', $paymentMethod->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Method Image -->
<div class="mb-4">
    <h5 class="mb-3"><i class="fas fa-image me-2"></i>Payment Method Image</h5>
    
    <div class="row">
        <div class="col-md-6">
            <!-- Current Image -->
            @if($paymentMethod->image)
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div class="border rounded p-3 text-center">
                    <img src="{{ asset('storage/' . $paymentMethod->image) }}" 
                         alt="{{ $paymentMethod->name }}" 
                         class="img-fluid mb-2" style="max-height: 100px;">
                    <div class="form-text">This image appears to customers during checkout</div>
                </div>
            </div>
            @endif
            
            <!-- Upload New Image -->
            <div class="mb-3">
                <label for="image" class="form-label">
                    {{ $paymentMethod->image ? 'Change Image' : 'Upload Image' }}
                </label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" accept="image/*">
                
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <div class="form-text">
                    Upload logo/image for this payment method (PNG, JPG, SVG). 
                    Recommended size: 100x60px. Max: 2MB.
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Image Preview -->
            <div class="mb-3">
                <label class="form-label">Image Preview</label>
                <div class="border rounded p-3 text-center" id="imagePreview" 
                     style="min-height: 120px; display: {{ $paymentMethod->image ? 'none' : 'block' }};">
                    
                    @if($paymentMethod->image)
                        <img src="{{ asset('storage/' . $paymentMethod->image) }}" 
                             alt="Preview" class="img-fluid" style="max-height: 100px;">
                    @else
                        <div class="text-muted py-4">
                            <i class="fas fa-image fa-2x mb-2"></i>
                            <p class="mb-0">No image selected</p>
                            <small>Preview will appear here</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
                        </div>

                        <!-- Status Settings -->
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-toggle-on me-2"></i>Status Settings</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong>Active</strong>
                                        </label>
                                    </div>
                                    <div class="form-text">When active, this payment method will be shown to customers</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_default" name="is_default" 
                                               value="1" {{ old('is_default', $paymentMethod->is_default) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_default">
                                            <strong>Default Payment Method</strong>
                                        </label>
                                    </div>
                                    <div class="form-text">This will be selected by default for customers</div>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration Fields -->
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-cog me-2"></i>Configuration</h5>
                            
                            @php
                                $configFields = $paymentMethod->getConfigurationFields();
                                $credentials = $paymentMethod->credentials ?? [];
                            @endphp

                            @if(!empty($configFields))
                                @if($paymentMethod->type == 'paystack')
                                <div class="alert alert-warning mb-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    You need to register on <a href="https://paystack.com" target="_blank" class="alert-link">Paystack.com</a> to get API keys
                                </div>
                                @endif

                                @foreach($configFields as $field)
                                    <div class="mb-3">
                                        <label for="{{ $field['name'] }}" class="form-label">
                                            {{ $field['label'] }}
                                            @if(isset($field['required']) && $field['required'])
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        
                                        @if($field['type'] == 'textarea')
                                            <textarea class="form-control @error('credentials.' . $field['name']) is-invalid @enderror" 
                                                      id="{{ $field['name'] }}" name="{{ $field['name'] }}" 
                                                      rows="3" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>{{ old($field['name'], $paymentMethod->getConfigValue($field['name'], $field['default'] ?? '')) }}</textarea>
                                        @elseif($field['type'] == 'select')
                                            <select class="form-control @error('credentials.' . $field['name']) is-invalid @enderror" 
                                                    id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                                    {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                                                <option value="">-- Select {{ $field['label'] }} --</option>
                                                @foreach($field['options'] as $value => $label)
                                                    <option value="{{ $value }}" {{ old($field['name'], $paymentMethod->getConfigValue($field['name'])) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="{{ $field['type'] }}" 
                                                   class="form-control @error('credentials.' . $field['name']) is-invalid @enderror" 
                                                   id="{{ $field['name'] }}" name="{{ $field['name'] }}" 
                                                   value="{{ old($field['name'], $paymentMethod->getConfigValue($field['name'], $field['default'] ?? '')) }}"
                                                   {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                                   {{ $field['type'] == 'password' ? 'autocomplete="new-password"' : '' }}>
                                        @endif
                                        
                                        @if(isset($field['help']))
                                            <div class="form-text">{{ $field['help'] }}</div>
                                        @endif
                                        
                                        @error('credentials.' . $field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    This payment method doesn't require any additional configuration.
                                </div>
                            @endif
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                            
                            @if(!$paymentMethod->is_default)
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-lightbulb me-2"></i>Tips</h5>
                    <ul class="mb-0">
                        <li>Keep API keys secure and never share them</li>
                        <li>Test payment gateway after configuration</li>
                        <li>Only one payment method can be default at a time</li>
                        <li>Inactive methods won't show to customers</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-history me-2"></i>Payment Method Info</h5>
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Created</dt>
                        <dd class="col-sm-7">{{ $paymentMethod->created_at->format('M d, Y') }}</dd>
                        
                        <dt class="col-sm-5">Last Updated</dt>
                        <dd class="col-sm-7">{{ $paymentMethod->updated_at->format('M d, Y') }}</dd>
                        
                        <dt class="col-sm-5">Type</dt>
                        <dd class="col-sm-7 text-capitalize">{{ str_replace('_', ' ', $paymentMethod->type) }}</dd>
                        
                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">
                            @if($paymentMethod->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if(!$paymentMethod->is_default)
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $paymentMethod->name }}</strong>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.payments.destroy', $paymentMethod->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script>

    // Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid" style="max-height: 100px;">`;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = `
            <div class="text-muted py-4">
                <i class="fas fa-image fa-2x mb-2"></i>
                <p class="mb-0">No image selected</p>
                <small>Preview will appear here</small>
            </div>`;
    }
});
</script>
@endsection
