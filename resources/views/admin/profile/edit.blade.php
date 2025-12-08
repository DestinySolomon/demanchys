<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        .profile-img-container {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            position: relative;
        }
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #f8f9fc;
        }
        .profile-initial {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
            color: white;
            background: linear-gradient(45deg, #4e73df, #224abe);
        }
        .btn-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #3e5dbf, #1a3a9e);
        }
        .btn-warning {
            background: linear-gradient(45deg, #f6c23e, #dda20a);
            border: none;
            color: #000;
        }
        .btn-warning:hover {
            background: linear-gradient(45deg, #e0b236, #c59209);
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 text-gray-800 mb-1">Edit Profile</h1>
                <p class="text-muted">Update your personal information and settings</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Left Column - Profile Form -->
            <div class="col-lg-8">
                <!-- Profile Information Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i> Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- Profile Image -->
                                <div class="col-md-4 mb-4">
                                    <div class="profile-img-container mb-3">
                                        @if($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="profile-img"
                                                 id="profileImagePreview">
                                        @else
                                            <div class="profile-initial" id="profileInitial">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <input type="file" 
                                               class="form-control" 
                                               id="profile_image" 
                                               name="profile_image" 
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                        <div class="form-text">Max 2MB. JPG, PNG, GIF allowed.</div>
                                        @error('profile_image')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Personal Information -->
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
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
                                        
                                        <div class="col-md-6 mb-3">
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
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="mobile_number" class="form-label">Mobile Number</label>
                                            <input type="text" 
                                                   class="form-control @error('mobile_number') is-invalid @enderror" 
                                                   id="mobile_number" 
                                                   name="mobile_number" 
                                                   value="{{ old('mobile_number', $user->mobile_number) }}">
                                            @error('mobile_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" 
                                                      name="address" 
                                                      rows="2">{{ old('address', $user->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12 mb-3">
                                            <label for="bio" class="form-label">Bio</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                      id="bio" 
                                                      name="bio" 
                                                      rows="3"
                                                      placeholder="Tell us a little about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Social Media Section -->
                            <div class="border-top pt-4 mt-4">
                                <h6 class="mb-3"><i class="fas fa-share-alt me-2"></i> Social Media Links</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="facebook_url" class="form-label">
                                            <i class="fab fa-facebook text-primary me-2"></i> Facebook URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('facebook_url') is-invalid @enderror" 
                                               id="facebook_url" 
                                               name="facebook_url" 
                                               value="{{ old('facebook_url', $user->facebook_url) }}"
                                               placeholder="https://facebook.com/yourprofile">
                                        @error('facebook_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="twitter_url" class="form-label">
                                            <i class="fab fa-twitter text-info me-2"></i> Twitter URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('twitter_url') is-invalid @enderror" 
                                               id="twitter_url" 
                                               name="twitter_url" 
                                               value="{{ old('twitter_url', $user->twitter_url) }}"
                                               placeholder="https://twitter.com/yourprofile">
                                        @error('twitter_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="instagram_url" class="form-label">
                                            <i class="fab fa-instagram text-danger me-2"></i> Instagram URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('instagram_url') is-invalid @enderror" 
                                               id="instagram_url" 
                                               name="instagram_url" 
                                               value="{{ old('instagram_url', $user->instagram_url) }}"
                                               placeholder="https://instagram.com/yourprofile">
                                        @error('instagram_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="linkedin_url" class="form-label">
                                            <i class="fab fa-linkedin text-primary me-2"></i> LinkedIn URL
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('linkedin_url') is-invalid @enderror" 
                                               id="linkedin_url" 
                                               name="linkedin_url" 
                                               value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                               placeholder="https://linkedin.com/in/yourprofile">
                                        @error('linkedin_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Password & Account Info -->
            <div class="col-lg-4">
                <!-- Change Password Card -->
                <div class="card mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0 text-dark"><i class="fas fa-key me-2"></i> Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.update-password') }}" id="passwordForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password *</label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password *</label>
                                <input type="password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" 
                                       name="new_password" 
                                       required>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Minimum 8 characters</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password *</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation" 
                                       required>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-warning px-4">
                                    <i class="fas fa-key me-2"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Account Information Card -->
                <div class="card">
                    <div class="card-header bg-info">
                        <h5 class="mb-0 text-white"><i class="fas fa-info-circle me-2"></i> Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted">Account Created</label>
                            <p class="mb-0 fw-semibold">{{ $user->created_at->format('F d, Y') }}</p>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Last Updated</label>
                            <p class="mb-0 fw-semibold">{{ $user->updated_at->format('F d, Y') }}</p>
                            <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Role</label>
                            <p class="mb-0">
                                <span class="badge bg-primary px-3 py-2">{{ ucfirst($user->role ?? 'admin') }}</span>
                            </p>
                        </div>
                        
                        <hr>
                        
                        <div class="text-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Check if we have an image or initial display
                    const profileImg = document.getElementById('profileImagePreview');
                    const profileInitial = document.getElementById('profileInitial');
                    
                    if (profileImg) {
                        // Update existing image
                        profileImg.src = e.target.result;
                    } else if (profileInitial) {
                        // Replace initial with image
                        profileInitial.outerHTML = `
                            <img src="${e.target.result}" 
                                 alt="Profile Preview" 
                                 class="profile-img"
                                 id="profileImagePreview">
                        `;
                    }
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const profileForm = document.getElementById('profileForm');
            const passwordForm = document.getElementById('passwordForm');
            
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    // Add any additional client-side validation here
                    console.log('Profile form submitting...');
                });
            }
            
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('new_password_confirmation').value;
                    
                    if (newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('New password and confirmation do not match!');
                        return false;
                    }
                    
                    if (newPassword.length < 8) {
                        e.preventDefault();
                        alert('Password must be at least 8 characters long!');
                        return false;
                    }
                    
                    console.log('Password form submitting...');
                });
            }
        });
    </script>
</body>
</html>