@extends('layouts.user-dashboard-clean')

@section('title', 'Edit Profile - Demanchys Lounge')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-2 text-muted">Edit Profile</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Profile Information -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card">
                <h4 class="mb-4">Profile Information</h4>
                
                <form method="POST" action="{{ route('user.update-profile') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            Please fix the following errors:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Profile Picture -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                             alt="Profile Picture" 
                                             class="rounded-circle border profile-image-preview" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle border d-flex align-items-center justify-content-center bg-light profile-image-preview" 
                                             style="width: 150px; height: 150px;">
                                            <i class="bi bi-person fs-1 text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute bottom-0 end-0">
                                        <label for="profile_image" class="btn btn-warning btn-sm rounded-circle" style="cursor: pointer;">
                                            <i class="bi bi-camera"></i>
                                        </label>
                                        <input type="file" 
                                               id="profile_image" 
                                               name="profile_image" 
                                               class="d-none" 
                                               accept="image/*">
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">Click camera icon to change</small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="mobile_number" class="form-label text-muted">Phone Number</label>
                                <input type="tel" 
                                       class="form-control @error('mobile_number') is-invalid @enderror" 
                                       id="mobile_number" 
                                       name="mobile_number" 
                                       value="{{ old('mobile_number', $user->mobile_number) }}">
                                @error('mobile_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <h5 class="mb-3 text-muted">Additional Information</h5>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label text-muted">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" 
                                  name="address" 
                                  rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label text-muted">Bio</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" 
                                  name="bio" 
                                  rows="3">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback text-muted">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Tell us a little about yourself</small>
                    </div>
                    
                    <!-- Social Media Links -->
                    <h5 class="mb-3">Social Media Links</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="facebook_url" class="form-label">
                                <i class="bi bi-facebook me-1"></i> Facebook
                            </label>
                            <input type="url" 
                                   class="form-control @error('facebook_url') is-invalid @enderror" 
                                   id="facebook_url" 
                                   name="facebook_url" 
                                   placeholder="https://facebook.com/username"
                                   value="{{ old('facebook_url', $user->facebook_url) }}">
                            @error('facebook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="instagram_url" class="form-label">
                                <i class="bi bi-instagram me-1"></i> Instagram
                            </label>
                            <input type="url" 
                                   class="form-control @error('instagram_url') is-invalid @enderror" 
                                   id="instagram_url" 
                                   name="instagram_url" 
                                   placeholder="https://instagram.com/username"
                                   value="{{ old('instagram_url', $user->instagram_url) }}">
                            @error('instagram_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="twitter_url" class="form-label">
                                <i class="bi bi-twitter me-1"></i> Twitter
                            </label>
                            <input type="url" 
                                   class="form-control @error('twitter_url') is-invalid @enderror" 
                                   id="twitter_url" 
                                   name="twitter_url" 
                                   placeholder="https://twitter.com/username"
                                   value="{{ old('twitter_url', $user->twitter_url) }}">
                            @error('twitter_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="linkedin_url" class="form-label">
                                <i class="bi bi-linkedin me-1"></i> LinkedIn
                            </label>
                            <input type="url" 
                                   class="form-control @error('linkedin_url') is-invalid @enderror" 
                                   id="linkedin_url" 
                                   name="linkedin_url" 
                                   placeholder="https://linkedin.com/in/username"
                                   value="{{ old('linkedin_url', $user->linkedin_url) }}">
                            @error('linkedin_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Right Column - Account Summary -->
        <div class="col-lg-4 mb-4">
            <!-- Account Summary -->
            <div class="dashboard-card mb-4">
                <h5 class="mb-3">Account Summary</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Member Since</span>
                        <span class="fw-medium">{{ $user->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Last Updated</span>
                        <span class="fw-medium">{{ $user->updated_at->format('M d, Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Total Orders</span>
                        <span class="fw-medium">{{ $orderStats['total'] ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Active Orders</span>
                        <span class="fw-medium">{{ $orderStats['active'] ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Bookings</span>
                        <span class="fw-medium">{{ $bookingStats['total'] ?? 0 }}</span>
                    </li>
                </ul>
            </div>
            
            <!-- Profile Completion -->
            <div class="dashboard-card">
                <h5 class="mb-3">Profile Completion</h5>
                
                @php
                    $completionItems = [
                        'Profile Picture' => !empty($user->profile_image),
                        'Phone Number' => !empty($user->mobile_number),
                        'Address' => !empty($user->address),
                        'Bio' => !empty($user->bio),
                    ];
                    
                    $completed = array_sum($completionItems);
                    $total = count($completionItems);
                    $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
                @endphp
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Progress</span>
                        <span class="fw-medium">{{ $percentage }}%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%;"></div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted d-block mb-2">Complete your profile:</small>
                    <ul class="list-unstyled mb-0">
                        @foreach($completionItems as $item => $isComplete)
                            <li class="mb-1">
                                <i class="bi {{ $isComplete ? 'bi-check-circle text-success' : 'bi-circle text-muted' }} me-2"></i>
                                <span class="{{ $isComplete ? 'text-muted' : '' }}">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview profile image before upload
        const profileImageInput = document.getElementById('profile_image');
        const profileImagePreview = document.querySelector('.profile-image-preview');
        
        if (profileImageInput) {
            profileImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Image size should be less than 2MB');
                        this.value = '';
                        return;
                    }
                    
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please upload a valid image (JPEG, PNG, JPG, GIF)');
                        this.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Check if it's an image element or div
                        if (profileImagePreview.tagName === 'IMG') {
                            profileImagePreview.src = e.target.result;
                        } else {
                            // Replace div with image
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Profile Preview';
                            img.className = 'rounded-circle border profile-image-preview';
                            img.style.width = '150px';
                            img.style.height = '150px';
                            img.style.objectFit = 'cover';
                            
                            profileImagePreview.parentNode.replaceChild(img, profileImagePreview);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const name = document.getElementById('name').value;
                
                if (!name.trim()) {
                    e.preventDefault();
                    alert('Please enter your full name.');
                    return;
                }
                
                if (!email.trim()) {
                    e.preventDefault();
                    alert('Please enter your email address.');
                    return;
                }
                
                // Validate email format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address.');
                    return;
                }
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';
                    submitBtn.disabled = true;
                }
            });
        }
    });
</script>
@endpush

<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 4px;
    }
    
    .progress-bar {
        border-radius: 4px;
    }
    
    .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    
    .rounded-circle.border {
        border: 3px solid #ffc107 !important;
    }
    
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #000;
    }
    
    .profile-image-preview {
        transition: all 0.3s ease;
    }
</style>
@endsection