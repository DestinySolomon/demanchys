@extends('layouts.user-dashboard-clean')

@section('title', 'Checkout - Demanchys Lounge')

@section('content')
<div class="checkout-container">
    <!-- Page Header -->
    <div class="dashboard-header mb-4">
        <h1 class="dashboard-title mb-2">
            <i class="bi bi-cart-check-fill text-warning me-2"></i>
            Checkout
        </h1>
        <p class="mb-0">Complete your order with secure payment</p>
    </div>

    <div class="row">
        <!-- Left Column - Order Details & Delivery -->
        <div class="col-lg-7">
            <!-- Delivery Information -->
            <div class="dashboard-card mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-truck me-2"></i>
                        Delivery Information
                    </h5>
                </div>
                
                <div class="card-body">
                    <form id="deliveryForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="customer_name" 
                                       name="customer_name"
                                       value="{{ $user->name ?? '' }}"
                                       required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="customer_phone" 
                                       name="customer_phone"
                                       value="{{ $user->mobile_number ?? '' }}"
                                       required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       id="customer_email" 
                                       name="customer_email"
                                       value="{{ $user->email ?? '' }}"
                                       required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="delivery_time" class="form-label">
                                    Preferred Delivery Time
                                </label>
                                <select class="form-select" id="delivery_time" name="delivery_time">
                                    <option value="asap">As Soon As Possible</option>
                                    <option value="30min">Within 30 minutes</option>
                                    <option value="1hour">Within 1 hour</option>
                                    <option value="2hours">Within 2 hours</option>
                                    <option value="specific">Specific Time</option>
                                </select>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="customer_address" class="form-label">
                                    Delivery Address <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" 
                                          id="customer_address" 
                                          name="customer_address"
                                          rows="3"
                                          required>{{ $user->address ?? '' }}</textarea>
                                <small class="form-text text-muted">Please include street name, house number, and landmark</small>
                            </div>
                            
                            <!-- Recent Addresses -->
                            @if($recentAddresses->count() > 0)
                                <div class="col-12 mb-3">
                                    <label class="form-label">Recent Addresses:</label>
                                    <div class="recent-addresses">
                                        @foreach($recentAddresses as $address)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="recent_address" 
                                                       id="address{{ $loop->index }}"
                                                       data-address="{{ $address->customer_address }}"
                                                       data-phone="{{ $address->customer_phone }}"
                                                       data-name="{{ $address->customer_name }}">
                                                <label class="form-check-label" for="address{{ $loop->index }}">
                                                    <strong>{{ $address->customer_name }}</strong> - 
                                                    {{ $address->customer_phone }}<br>
                                                    <small>{{ Str::limit($address->customer_address, 80) }}</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <div class="col-12 mb-3">
                                <label for="delivery_instructions" class="form-label">
                                    Delivery Instructions
                                </label>
                                <textarea class="form-control" 
                                          id="delivery_instructions" 
                                          name="delivery_instructions"
                                          rows="2"
                                          placeholder="Any special instructions for delivery...">{{ $deliveryInstructions }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Payment Method -->
            <div class="dashboard-card">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-credit-card me-2"></i>
                        Payment Method
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="payment-methods">
                        <div class="form-check mb-3">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="payment_card"
                                   value="card"
                                   checked>
                            <label class="form-check-label w-100" for="payment_card">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="bi bi-credit-card-fill me-2 text-primary"></i>
                                        <strong>Credit/Debit Card</strong>
                                        <p class="small mb-0">Pay securely with Paystack</p>
                                    </div>
                                    <div class="payment-icons">
                                        <i class="bi bi-paypal me-2"></i>
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="payment_transfer"
                                   value="transfer">
                            <label class="form-check-label w-100" for="payment_transfer">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="bi bi-bank me-2 text-success"></i>
                                        <strong>Bank Transfer</strong>
                                        <p class="small mb-0">Transfer to our bank account</p>
                                    </div>
                                    <div class="payment-icons">
                                        <i class="bi bi-building"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="payment_cash"
                                   value="cash">
                            <label class="form-check-label w-100" for="payment_cash">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="bi bi-cash-stack me-2 text-warning"></i>
                                        <strong>Cash on Delivery</strong>
                                        <p class="small mb-0">Pay when you receive your order</p>
                                    </div>
                                    <div class="payment-icons">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Payment Note -->
                    <div class="alert alert-info mt-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle me-2"></i>
                            <div>
                                <small>
                                    <strong>Note:</strong> All payments are processed securely. 
                                    For bank transfers, please include your order reference in the payment description.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Order Summary -->
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px;">
                <!-- Order Summary -->
                <div class="dashboard-card mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-receipt me-2"></i>
                            Order Summary
                        </h5>
                    </div>
                    
                    <div class="card-body">
                        <!-- Order Items Preview -->
                        <div class="order-items-preview mb-4">
                            <h6 class="mb-3">Order Items ({{ $cartCount }})</h6>
                            <div class="items-list">
                                @foreach($cartItems as $item)
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0">
                                            @if($item->menuItem->image)
                                                <img src="{{ asset('storage/' . $item->menuItem->image) }}" 
                                                     alt="{{ $item->menuItem->name }}"
                                                     class="rounded"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-0 small">{{ $item->menuItem->name }}</p>
                                            <p class="mb-0 small">
                                                {{ $item->quantity }} × ₦{{ number_format($item->menuItem->price, 2) }}
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <p class="mb-0 small fw-semibold">
                                                ₦{{ number_format($item->menuItem->price * $item->quantity, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Price Breakdown -->
                        <div class="price-breakdown">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span class="fw-semibold">₦{{ number_format($cartSubtotal, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (7.5%)</span>
                                <span class="fw-semibold">₦{{ number_format($taxAmount, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Delivery Fee</span>
                                <span class="fw-semibold">₦{{ number_format($deliveryFee, 2) }}</span>
                            </div>
                            
                            @if($discountAmount > 0)
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>
                                        <i class="bi bi-tag-fill me-1"></i>
                                        {{ $appliedCoupon['name'] ?? $appliedCoupon['code'] }}
                                    </span>
                                    <span class="fw-semibold">-₦{{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif
                            
                            <hr class="my-3">
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-warning">₦{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        
                        <!-- Terms Agreement -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                            <label class="form-check-label small" for="agreeTerms">
                                I agree to the <a href="{{ route('terms') }}" target="_blank">Terms of Service</a> 
                                and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>. 
                                I understand that all sales are final.
                            </label>
                        </div>
                        
                        <!-- Checkout Button -->
                        <button class="btn btn-warning btn-lg w-100 mb-3" id="placeOrderBtn">
                            <i class="bi bi-lock-fill me-2"></i>
                            Place Order
                        </button>
                        
                        <div class="text-center">
                            <small>
                                <i class="bi bi-shield-check me-1"></i>
                                Secure checkout • 100% Safe & Secure
                            </small>
                        </div>
                        
                        <!-- Continue Shopping -->
                        <div class="text-center mt-3">
                            <a href="{{ route('user.cart') }}" class="btn btn-link text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i>
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Security Assurance -->
                <div class="dashboard-card">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check display-5 text-success mb-3"></i>
                        <h6 class="mb-2">Secure Payment</h6>
                        <p class="small mb-0">
                            Your payment information is encrypted and secure. 
                            We never store your credit card details.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #eaeaea;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .card-header {
        padding: 1rem 1.5rem;
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
        font-weight: 500;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s;
        color: #2d3748;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #ffc107;
        border-color: #ffc107;
    }
    
    .form-check-input:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    
    .payment-methods .form-check-label {
        cursor: pointer;
        padding: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.2s;
        color: #2d3748;
    }
    
    .payment-methods .form-check-input:checked + .form-check-label {
        border-color: #ffc107;
        background-color: rgba(255, 193, 7, 0.05);
    }
    
    .payment-icons {
        font-size: 1.5rem;
        color: #6c757d;
    }
    
    .items-list {
        max-height: 200px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }
    
    .items-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .items-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .items-list::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ffb347);
        border: none;
        color: #000;
        font-weight: 600;
        padding: 1rem;
        transition: all 0.3s;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #e6a700, #ffa500);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }
    
    .btn-warning:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .recent-addresses .form-check-label {
        cursor: pointer;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        transition: all 0.2s;
        color: #2d3748;
    }
    
    .recent-addresses .form-check-input:checked + .form-check-label {
        border-color: #ffc107;
        background-color: rgba(255, 193, 7, 0.05);
    }
    
    .sticky-top {
        z-index: 10;
    }
    
    /* Ensure all text is visible */
    .dashboard-header h1,
    .dashboard-header p,
    .dashboard-card h5,
    .dashboard-card h6,
    .dashboard-card p,
    .dashboard-card span,
    .dashboard-card label,
    .dashboard-card small:not(.form-text) {
        color: #2d3748 !important;
    }
    
    /* Keep muted text only for hints/helper text */
    .form-text.text-muted {
        color: #6c757d !important;
    }
    
    @media (max-width: 768px) {
        .payment-methods .form-check-label {
            padding: 0.75rem;
        }
        
        .btn-lg {
            padding: 0.875rem;
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        const deliveryForm = document.getElementById('deliveryForm');
        
        // Auto-fill recent addresses
        document.querySelectorAll('input[name="recent_address"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('customer_name').value = this.getAttribute('data-name');
                    document.getElementById('customer_phone').value = this.getAttribute('data-phone');
                    document.getElementById('customer_address').value = this.getAttribute('data-address');
                }
            });
        });
        
        // Place order
        placeOrderBtn.addEventListener('click', function() {
            if (!validateForm()) {
                return;
            }
            
            // Collect form data
            const formData = {
                customer_name: document.getElementById('customer_name').value,
                customer_phone: document.getElementById('customer_phone').value,
                customer_email: document.getElementById('customer_email').value,
                customer_address: document.getElementById('customer_address').value,
                delivery_instructions: document.getElementById('delivery_instructions').value,
                payment_method: document.querySelector('input[name="payment_method"]:checked').value,
            };
            
            // Show loading state
            const originalText = placeOrderBtn.innerHTML;
            placeOrderBtn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-2"></i> Processing...';
            placeOrderBtn.disabled = true;
            
            // Process checkout
           fetch("{{ route('user.checkout.process') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.payment_method === 'card') {
                        // Redirect to Paystack payment page
                        window.location.href = data.authorization_url;
                    } else {
                        // For cash/transfer, redirect to success page
                        window.location.href = data.redirect_url + '?ref=' + data.order_ref;
                    }
                } else {
                    showAlert(data.message || 'Checkout failed. Please try again.', 'error');
                    placeOrderBtn.innerHTML = originalText;
                    placeOrderBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
                placeOrderBtn.innerHTML = originalText;
                placeOrderBtn.disabled = false;
            });
        });
        
        // Form validation
        function validateForm() {
            const requiredFields = [
                'customer_name',
                'customer_phone',
                'customer_email',
                'customer_address'
            ];
            
            let isValid = true;
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Email validation
            const emailField = document.getElementById('customer_email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailField.value && !emailRegex.test(emailField.value)) {
                emailField.classList.add('is-invalid');
                isValid = false;
            }
            
            // Terms agreement
            if (!document.getElementById('agreeTerms').checked) {
                showAlert('Please agree to the terms and conditions.', 'error');
                isValid = false;
            }
            
            return isValid;
        }
        
        // Real-time validation
        document.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
        
        // Alert function
        function showAlert(message, type) {
            // Remove any existing alerts
            const existingAlert = document.querySelector('.custom-alert');
            if (existingAlert) existingAlert.remove();
            
            // Create alert element
            const alert = document.createElement('div');
            alert.className = `custom-alert alert alert-${type}`;
            alert.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                border-radius: 10px;
                animation: slideIn 0.3s ease;
            `;
            
            alert.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'} me-2"></i>
                    <div>${message}</div>
                </div>
            `;
            
            document.body.appendChild(alert);
            
            // Remove alert after 5 seconds
            setTimeout(() => {
                alert.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        }
        
        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .bi-arrow-clockwise.spin {
                animation: spin 1s linear infinite;
                display: inline-block;
            }
            .is-invalid {
                border-color: #dc3545 !important;
            }
            .is-invalid:focus {
                box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush
@endsection