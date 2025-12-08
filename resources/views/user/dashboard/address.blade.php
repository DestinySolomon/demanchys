@extends('layouts.user-dashboard-clean')

@section('title', 'My Address - Demanchys Lounge')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-2 text-muted">My Address</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Address</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Primary Address Section -->
    <div class="dashboard-card mb-4">
        <h4 class="mb-4">
            <i class="bi bi-house-check-fill text-warning me-2"></i>
            Primary Address
        </h4>
        
        @if($user->address)
        <div class="row">
            <div class="col-md-8">
                <div class="address-card bg-light rounded p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1 text-black">{{ $user->name }}</h5>
                            <p class="text-muted mb-1">{{ $user->mobile_number ?? 'No phone number' }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="toggleEditForm()">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <form method="POST" action="{{ route('user.address.delete') }}" 
                                  onsubmit="return confirm('Are you sure you want to remove this address?');"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="mb-0 text-dark">{{ $user->address }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-warning bg-opacity-10 rounded p-3 h-100">
                    <h6 class="text-warning mb-3">
                        <i class="bi bi-info-circle me-2"></i> Address Info
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span class="small text-muted">Default delivery address</span>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-truck text-primary me-2"></i>
                            <span class="small text-muted">Used for all orders</span>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt text-info me-2"></i>
                            <span class="small text-muted">Saved to your profile</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @else
        <!-- No Address - Show Add Form -->
        <div class="text-center py-4">
            <i class="bi bi-house-x fs-1 text-muted mb-3"></i>
            <h5 class="text-muted mb-3 text-muted">No Primary Address</h5>
            <p class="text-black mb-4">Add your primary address for faster checkout.</p>
        </div>
        @endif

        <!-- Edit/Add Address Form (Initially hidden if address exists) -->
       <div class="address-form-container" id="addressForm" style="{{ $user->address ? 'display: none;' : '' }}">
    <h5 class="mb-3 text-black">{{ $user->address ? 'Edit Address' : 'Add Primary Address' }}</h5>
    <form method="POST" action="{{ $user->address ? route('user.address.update') : route('user.address.store') }}">
        @csrf
        @if($user->address)
            @method('PUT')
        @endif
        
        <div class="row text-black">
            <div class="col-md-6 mb-3">
                <label for="full_name" class="form-label fw-medium">Full Name *</label>
                <input type="text" class="form-control" id="full_name" name="full_name" 
                       value="{{ $user->name }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label fw-medium">Phone Number *</label>
                <input type="tel" class="form-control" id="phone" name="phone" 
                       value="{{ $user->mobile_number }}" required>
            </div>
        </div>
        
        <div class="mb-3">
            <label for="address" class="form-label fw-medium text-black">Complete Address *</label>
            <textarea class="form-control" id="address" name="address" rows="4" 
                      placeholder="House no., Building, Street, Area, City, State" required>{{ $user->address }}</textarea>
            <small class="text-black">Please provide complete address for accurate delivery</small>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="landmark" class="form-label fw-medium text-black">Landmark (optional)</label>
                <input type="text" class="form-control" id="landmark" name="landmark" 
                       placeholder="E.g., Near police station, Opposite bank">
            </div>
            <div class="col-md-6 mb-3">
                <label for="address_type" class="form-label fw-medium text-black">Address Type</label>
                <select class="form-select" id="address_type" name="address_type">
                    <option value="home" selected>Home</option>
                    <option value="work">Work</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            @if($user->address)
                <button type="button" class="btn btn-outline-secondary" onclick="toggleEditForm()">
                    Cancel
                </button>
            @endif
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save me-1"></i>
                {{ $user->address ? 'Update Address' : 'Save Address' }}
            </button>
        </div>
    </form>
</div>
    </div>

    <!-- Recent Addresses from Orders -->
    @if($recentAddresses && $recentAddresses->count() > 0)
    <div class="dashboard-card">
        <h4 class="mb-4">
            <i class="bi bi-clock-history text-muted me-2"></i>
            Recent Delivery Addresses from Orders
        </h4>
        
        <p class="text-muted mb-3">Addresses you've used in previous orders:</p>
        
        <div class="row">
            @foreach($recentAddresses as $index => $address)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0">Address #{{ $index + 1 }}</h6>
                            <span class="badge bg-light text-muted small">From Order</span>
                        </div>
                        <p class="card-text small text-muted mb-3">{{ $address }}</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-warning flex-fill" 
                                    onclick="useThisAddress('{{ $address }}')">
                                <i class="bi bi-house-check me-1"></i> Use This
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" 
                                    onclick="copyToClipboard('{{ $address }}')">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Delivery Instructions -->
    <div class="dashboard-card mt-4">
        <h4 class="mb-3">
            <i class="bi bi-chat-text text-muted me-2"></i>
            Delivery Instructions
        </h4>
        
        <form method="POST" action="{{ route('user.address.instructions') }}">
            @csrf
            <div class="mb-3">
                <label for="delivery_instructions" class="form-label">Special instructions for delivery</label>
                <textarea class="form-control" id="delivery_instructions" name="delivery_instructions" rows="3" 
                          placeholder="E.g., Leave at the gate, Call before delivery, Deliver to security, etc.">{{ old('delivery_instructions', session('delivery_instructions') ?? '') }}</textarea>
                <small class="text-muted">These instructions will be included with all your orders</small>
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save me-1"></i> Save Instructions
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleEditForm() {
        const form = document.getElementById('addressForm');
        const addressCard = document.querySelector('.address-card');
        
        if (form.style.display === 'none') {
            form.style.display = 'block';
            if (addressCard) {
                addressCard.style.display = 'none';
            }
        } else {
            form.style.display = 'none';
            if (addressCard) {
                addressCard.style.display = 'block';
            }
        }
    }
    
    function useThisAddress(address) {
        document.getElementById('address').value = address;
        document.getElementById('addressForm').style.display = 'block';
        document.querySelector('.address-card').style.display = 'none';
        
        // Scroll to form
        document.getElementById('addressForm').scrollIntoView({ behavior: 'smooth' });
    }
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show temporary notification
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
            alert.style.zIndex = '1060';
            alert.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                Address copied to clipboard!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                alert.remove();
            }, 3000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            alert('Failed to copy address. Please try again.');
        });
    }
    
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const addressForm = document.querySelector('#addressForm form');
        if (addressForm) {
            addressForm.addEventListener('submit', function(e) {
                const address = document.getElementById('address').value;
                const phone = document.getElementById('phone').value;
                const name = document.getElementById('full_name').value;
                
                if (!name.trim()) {
                    e.preventDefault();
                    alert('Please enter your full name.');
                    return;
                }
                
                if (!phone.trim()) {
                    e.preventDefault();
                    alert('Please enter your phone number.');
                    return;
                }
                
                if (!address.trim()) {
                    e.preventDefault();
                    alert('Please enter your address.');
                    return;
                }
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';
                    submitBtn.disabled = true;
                }
            });
        }
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush

<style>
    .address-card {
        border-left: 4px solid #ffc107;
        transition: all 0.3s ease;
    }
    
    .card {
        transition: transform 0.2s;
        border: 1px solid #eaeaea;
        border-radius: 8px;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.25em 0.6em;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
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
    
    .address-form-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1rem;
    }
    
    .bg-warning.bg-opacity-10 {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
</style>
@endsection