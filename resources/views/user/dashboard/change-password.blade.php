@extends('layouts.user-dashboard-clean')

@section('title', 'Change Password - Demanchys Lounge')

@section('content')
<div class="change-password-container">
    <!-- Page Header -->
    <div class="dashboard-header mb-4 text-muted">
        <h1 class="dashboard-title mb-2">
            <i class="bi bi-key-fill text-warning me-2"></i>
            Change Password
        </h1>
        <p class="text-muted mb-0">Keep your account secure by updating your password regularly</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column - Form -->
        <div class="col-lg-8 text-muted">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Update Password
                    </h5>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('user.update-password') }}" method="POST" id="changePasswordForm">
                        @csrf
                        
                        <!-- Current Password -->
                        <div class="mb-4 text-muted">
                            <label for="current_password" class="form-label fw-semibold">
                                <i class="bi bi-key me-1"></i>
                                Current Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password"
                                       placeholder="Enter your current password"
                                       required>
                                <button class="btn btn-outline-secondary toggle-password" 
                                        type="button" 
                                        data-target="current_password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">You must confirm your current password to make changes</small>
                        </div>

                        <!-- New Password -->
                        <div class="mb-4 text-muted">
                            <label for="new_password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1"></i>
                                New Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" 
                                       name="new_password"
                                       placeholder="Enter new password (minimum 8 characters)"
                                       required
                                       minlength="8">
                                <button class="btn btn-outline-secondary toggle-password" 
                                        type="button" 
                                        data-target="new_password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Password Strength Meter -->
                            <div class="password-strength-meter mt-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Password strength:</small>
                                    <small class="fw-semibold text-muted" id="strengthText">None</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" id="strengthBar" role="progressbar"></div>
                                </div>
                            </div>
                            
                            <!-- Password Requirements -->
                            <div class="mt-3 text-muted">
                                <small class="text-muted d-block mb-2">Requirements:</small>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi requirement-icon" id="lengthIcon"></i>
                                            <small class="ms-2">At least 8 characters</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi requirement-icon" id="uppercaseIcon"></i>
                                            <small class="ms-2">One uppercase letter</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-muted">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi requirement-icon" id="lowercaseIcon"></i>
                                            <small class="ms-2">One lowercase letter</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi requirement-icon" id="numberIcon"></i>
                                            <small class="ms-2">One number</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4 text-muted">
                            <label for="new_password_confirmation" class="form-label fw-semibold">
                                <i class="bi bi-lock-fill me-1"></i>
                                Confirm New Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation"
                                       placeholder="Confirm your new password"
                                       required
                                       minlength="8">
                                <button class="btn btn-outline-secondary toggle-password" 
                                        type="button" 
                                        data-target="new_password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted" id="passwordMatchText"></small>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-warning btn-lg px-4">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Password
                            </button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-lg px-4 ms-2">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Security Tips -->
        <div class="col-lg-4">
            <div class="dashboard-card h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-check text-success me-2"></i>
                        Security Tips
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="security-tips">
                        <!-- Tip 1 -->
                        <div class="d-flex mb-3">
                            <div class="tip-icon me-3">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Use a Unique Password</h6>
                                <p class="text-muted small mb-0">Don't reuse passwords from other accounts</p>
                            </div>
                        </div>
                        
                        <!-- Tip 2 -->
                        <div class="d-flex mb-3">
                            <div class="tip-icon me-3">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Update Regularly</h6>
                                <p class="text-muted small mb-0">Change your password every 3-6 months</p>
                            </div>
                        </div>
                        
                        <!-- Tip 3 -->
                        <div class="d-flex mb-3">
                            <div class="tip-icon me-3">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Keep It Private</h6>
                                <p class="text-muted small mb-0">Never share your password with anyone</p>
                            </div>
                        </div>
                        
                        <!-- Tip 4 -->
                        <div class="d-flex mb-3">
                            <div class="tip-icon me-3">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Password Manager</h6>
                                <p class="text-muted small mb-0">Consider using a password manager</p>
                            </div>
                        </div>
                        
                        <!-- Tip 5 -->
                        <div class="d-flex">
                            <div class="tip-icon me-3">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Two-Factor Authentication</h6>
                                <p class="text-muted small mb-0">Enable 2FA if available</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Important Notice -->
                    <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25">
                        <div class="d-flex">
                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Important Notice</h6>
                                <p class="small mb-0">Changing your password will log you out from all other devices and sessions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .change-password-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .dashboard-header {
        padding: 1rem 0;
    }
    
    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
    }
    
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #eaeaea;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: box-shadow 0.3s;
    }
    
    .dashboard-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #eaeaea;
        background: #f8f9fa;
        border-radius: 10px 10px 0 0 !important;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0;
    }
    
    .form-label {
        color: #4a5568;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }
    
    .input-group .form-control {
        border-right: none;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        border-color: #dee2e6;
    }
    
    .input-group .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    
    .input-group .btn-outline-secondary {
        border-color: #dee2e6;
        background: #ffffff;
        border-left: none;
        transition: all 0.2s;
    }
    
    .input-group .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
    }
    
    .toggle-password {
        width: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .password-strength-meter {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #eaeaea;
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-bar {
        transition: width 0.3s ease, background-color 0.3s ease;
    }
    
    .requirement-icon {
        font-size: 1.25rem;
        color: #cbd5e0;
    }
    
    .requirement-icon.valid {
        color: #38a169;
    }
    
    .form-actions {
        padding-top: 1.5rem;
        border-top: 1px solid #eaeaea;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ffb347);
        border: none;
        color: #000;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #e6a700, #ffa500);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }
    
    .btn-outline-secondary {
        border: 2px solid #e2e8f0;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s;
    }
    
    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e0;
        transform: translateY(-2px);
    }
    
    .security-tips .tip-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .security-tips h6 {
        font-size: 0.95rem;
        color: #2d3748;
    }
    
    .alert-warning {
        border-left: 4px solid #ffc107;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .dashboard-main {
            padding: 1rem;
        }
        
        .dashboard-card {
            margin-bottom: 1rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn-warning, .btn-outline-secondary {
            width: 100%;
        }
        
        .btn-outline-secondary {
            margin-left: 0 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password visibility toggle
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });

        // Password strength indicator
        const passwordInput = document.getElementById('new_password');
        const confirmInput = document.getElementById('new_password_confirmation');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const matchText = document.getElementById('passwordMatchText');
        
        // Requirement icons
        const lengthIcon = document.getElementById('lengthIcon');
        const uppercaseIcon = document.getElementById('uppercaseIcon');
        const lowercaseIcon = document.getElementById('lowercaseIcon');
        const numberIcon = document.getElementById('numberIcon');

        // Initialize icons
        if (lengthIcon) lengthIcon.className = 'bi bi-x-circle text-danger';
        if (uppercaseIcon) uppercaseIcon.className = 'bi bi-x-circle text-danger';
        if (lowercaseIcon) lowercaseIcon.className = 'bi bi-x-circle text-danger';
        if (numberIcon) numberIcon.className = 'bi bi-x-circle text-danger';

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Check length
                const lengthValid = password.length >= 8;
                updateIcon('lengthIcon', lengthValid);
                if (lengthValid) strength += 25;
                
                // Check uppercase
                const uppercaseValid = /[A-Z]/.test(password);
                updateIcon('uppercaseIcon', uppercaseValid);
                if (uppercaseValid) strength += 25;
                
                // Check lowercase
                const lowercaseValid = /[a-z]/.test(password);
                updateIcon('lowercaseIcon', lowercaseValid);
                if (lowercaseValid) strength += 25;
                
                // Check number
                const numberValid = /[0-9]/.test(password);
                updateIcon('numberIcon', numberValid);
                if (numberValid) strength += 25;
                
                // Update progress bar
                if (strengthBar) {
                    strengthBar.style.width = strength + '%';
                    
                    // Update color based on strength
                    if (strength <= 25) {
                        strengthBar.className = 'progress-bar bg-danger';
                        strengthText.textContent = 'Weak';
                        strengthText.className = 'fw-semibold text-danger';
                    } else if (strength <= 50) {
                        strengthBar.className = 'progress-bar bg-warning';
                        strengthText.textContent = 'Fair';
                        strengthText.className = 'fw-semibold text-warning';
                    } else if (strength <= 75) {
                        strengthBar.className = 'progress-bar bg-info';
                        strengthText.textContent = 'Good';
                        strengthText.className = 'fw-semibold text-info';
                    } else {
                        strengthBar.className = 'progress-bar bg-success';
                        strengthText.textContent = 'Strong';
                        strengthText.className = 'fw-semibold text-success';
                    }
                }
            });
        }

        // Password match indicator
        if (passwordInput && confirmInput) {
            confirmInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirm = this.value;
                
                if (confirm.length === 0) {
                    matchText.textContent = '';
                    matchText.className = 'text-muted';
                } else if (password === confirm) {
                    matchText.textContent = '✓ Passwords match';
                    matchText.className = 'text-success fw-semibold';
                } else {
                    matchText.textContent = '✗ Passwords do not match';
                    matchText.className = 'text-danger fw-semibold';
                }
            });
        }

        function updateIcon(iconId, isValid) {
            const icon = document.getElementById(iconId);
            if (icon) {
                if (isValid) {
                    icon.className = 'bi bi-check-circle-fill text-success';
                } else {
                    icon.className = 'bi bi-x-circle text-danger';
                }
            }
        }

        // Form validation
        const form = document.getElementById('changePasswordForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const currentPassword = document.getElementById('current_password').value;
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('new_password_confirmation').value;
                
                // Check if passwords match
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Mismatch',
                        text: 'New password and confirmation password do not match.',
                        confirmButtonColor: '#ffc107',
                    });
                    return false;
                }
                
                // Check password strength
                if (newPassword.length < 8) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Weak Password',
                        text: 'Password must be at least 8 characters long.',
                        confirmButtonColor: '#ffc107',
                    });
                    return false;
                }
                
                // Check if current password is same as new password
                if (currentPassword === newPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Same Password',
                        text: 'New password must be different from current password.',
                        confirmButtonColor: '#ffc107',
                    });
                    return false;
                }
                
                return true;
            });
        }
    });
</script>
@endpush
@endsection