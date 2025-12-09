@extends('layouts.user-dashboard-clean')

@section('title', 'My Cart - Demanchys Lounge')

@section('content')
<div class="cart-container">
    <!-- Page Header -->
    <div class="dashboard-header mb-4">
        <h1 class="dashboard-title mb-2">
            <i class="bi bi-cart-fill text-warning me-2"></i>
            My Cart
            @if($cartCount > 0)
                <span class="badge bg-warning fs-6 ms-2">{{ $cartCount }} items</span>
            @endif
        </h1>
        <p class="text-muted mb-0">Review your items before checkout</p>
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

    @if($cartCount == 0)
        <!-- Empty Cart State -->
        <div class="dashboard-card text-center py-5">
            <div class="empty-cart-icon mb-4">
                <i class="bi bi-cart-x display-1 text-muted"></i>
            </div>
            <h3 class="mb-3">Your cart is empty</h3>
            <p class="text-muted mb-4">Add some delicious items from our menu to get started!</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('menu') }}" class="btn btn-warning btn-lg">
                    <i class="bi bi-menu-button-wide me-2"></i>
                    Browse Menu
                </a>
                <a href="{{ route('user.wishlist') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-heart me-2"></i>
                    View Wishlist
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <!-- Left Column - Cart Items -->
            <div class="col-lg-8">
                <div class="dashboard-card mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-basket me-2"></i>
                            Cart Items ({{ $cartCount }})
                        </h5>
                    </div>
                    
                    <div class="card-body p-0">
                        <!-- Cart Items List -->
                        <div class="cart-items">
                            @foreach($cartItems as $item)
                                <div class="cart-item border-bottom" data-item-id="{{ $item->menu_item_id }}">
                                    <div class="row align-items-center py-3">
                                        <!-- Item Image -->
                                        <div class="col-3 col-md-2">
                                            @if($item->menuItem->image)
                                                <img src="{{ asset('storage/' . $item->menuItem->image) }}" 
                                                     alt="{{ $item->menuItem->name }}"
                                                     class="img-fluid rounded"
                                                     style="height: 80px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="height: 80px; width: 80px;">
                                                    <i class="bi bi-image text-muted fs-4"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Item Details -->
                                        <div class="col-9 col-md-6">
                                            <h6 class="mb-1">{{ $item->menuItem->name }}</h6>
                                            @if($item->menuItem->description)
                                                <p class="text-muted small mb-1">{{ Str::limit($item->menuItem->description, 50) }}</p>
                                            @endif
                                            <p class="mb-0 fw-semibold text-warning">
                                                ₦{{ number_format($item->menuItem->price, 2) }}
                                            </p>
                                            
                                            <!-- Special Instructions -->
                                            @if($item->special_instructions)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="bi bi-chat-left-text me-1"></i>
                                                        {{ $item->special_instructions }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Quantity Controls -->
                                        <div class="col-6 col-md-2 mt-3 mt-md-0">
                                            <div class="quantity-controls">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary quantity-decrease" 
                                                            type="button"
                                                            data-item-id="{{ $item->menu_item_id }}">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="form-control text-center quantity-input"
                                                           value="{{ $item->quantity }}"
                                                           min="1"
                                                           max="99"
                                                           data-item-id="{{ $item->menu_item_id }}">
                                                    <button class="btn btn-outline-secondary quantity-increase" 
                                                            type="button"
                                                            data-item-id="{{ $item->menu_item_id }}">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Subtotal & Remove -->
                                        <div class="col-6 col-md-2 text-end mt-3 mt-md-0">
                                            <p class="mb-1 fw-semibold">
                                                ₦{{ number_format($item->menuItem->price * $item->quantity, 2) }}
                                            </p>
                                            <button class="btn btn-link text-danger btn-sm remove-item"
                                                    data-item-id="{{ $item->menu_item_id }}">
                                                <i class="bi bi-trash me-1"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Cart Actions -->
                        <div class="p-3 border-top">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('menu') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Continue Shopping
                                </a>
                                <button class="btn btn-danger" id="clearCartBtn">
                                    <i class="bi bi-trash me-2"></i>
                                    Clear Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Special Instructions -->
                <div class="dashboard-card mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="card-title mb-0">
                            <i class="bi bi-chat-left-text me-2"></i>
                            Special Instructions
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" 
                                  id="specialInstructions" 
                                  rows="3" 
                                  placeholder="Any special requests or delivery instructions..."></textarea>
                        <small class="text-muted">Note: These instructions will apply to all items in your order.</small>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Order Summary -->
            <div class="col-lg-4">
                <div class="dashboard-card mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-receipt me-2"></i>
                            Order Summary
                        </h5>
                    </div>
                    
                    <div class="card-body">
                        <!-- Order Summary Details -->
                        <div class="order-summary">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-semibold" id="subtotalAmount">
                                    ₦{{ number_format($cartSubtotal, 2) }}
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tax (7.5%)</span>
                                <span class="fw-semibold" id="taxAmount">
                                    ₦{{ number_format($taxAmount, 2) }}
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Delivery Fee</span>
                                <span class="fw-semibold text-muted" id="deliveryFee">
                                    ₦{{ number_format($deliveryFee, 2) }}
                                </span>
                            </div>
                            
                            <!-- Coupon Section -->
                            @if($appliedCoupon)
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>
                                        <i class="bi bi-tag-fill me-1"></i>
                                        {{ $appliedCoupon['name'] ?? $appliedCoupon['code'] }}
                                        <button class="btn btn-link btn-sm text-danger p-0 ms-2" id="removeCouponBtn">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </span>
                                    <span class="fw-semibold" id="discountAmount">
                                        -₦{{ number_format($discountAmount, 2) }}
                                    </span>
                                </div>
                            @else
                                <div class="coupon-section mb-3">
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control" 
                                               id="couponCode" 
                                               placeholder="Coupon code">
                                        <button class="btn btn-outline-warning" id="applyCouponBtn">
                                            Apply
                                        </button>
                                    </div>
                                    <div id="couponMessage" class="mt-1"></div>
                                </div>
                            @endif
                            
                            <hr class="my-3">
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-warning" id="totalAmount">
                                    ₦{{ number_format($total, 2) }}
                                </span>
                            </div>
                            
                            <!-- Checkout Button -->
                            <button class="btn btn-warning btn-lg w-100 mb-3" id="checkoutBtn">
                                <i class="bi bi-lock-fill me-2"></i>
                                Proceed to Checkout
                            </button>
                            
                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Secure checkout powered by Paystack
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Methods -->
                <div class="dashboard-card">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="card-title mb-0">
                            <i class="bi bi-credit-card me-2"></i>
                            Payment Methods
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-credit-card me-1"></i> Card
                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-bank me-1"></i> Bank Transfer
                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-cash-stack me-1"></i> Cash on Delivery
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .cart-container {
        max-width: 1200px;
        margin: 0 auto;
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
    
    .cart-item:hover {
        background-color: #fafafa;
    }
    
    .quantity-controls .input-group {
        width: 120px;
    }
    
    .quantity-input {
        max-width: 50px;
        border-color: #dee2e6;
    }
    
    .quantity-input:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    
    .quantity-decrease, .quantity-increase {
        width: 36px;
    }
    
    .remove-item {
        font-size: 0.875rem;
        text-decoration: none;
    }
    
    .remove-item:hover {
        text-decoration: underline;
    }
    
    .order-summary {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ffb347);
        border: none;
        color: #000;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #e6a700, #ffa500);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }
    
    .empty-cart-icon {
        color: #e2e8f0;
    }
    
    #couponMessage {
        font-size: 0.875rem;
    }
    
    #couponMessage.success {
        color: #38a169;
    }
    
    #couponMessage.error {
        color: #e53e3e;
    }
    
    @media (max-width: 768px) {
        .cart-item .row {
            padding: 1rem 0;
        }
        
        .quantity-controls .input-group {
            width: 100px;
        }
        
        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Update quantity
        document.querySelectorAll('.quantity-decrease, .quantity-increase, .quantity-input').forEach(element => {
            if (element.classList.contains('quantity-decrease')) {
                element.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                    let quantity = parseInt(input.value) - 1;
                    if (quantity >= 1) {
                        updateCartItem(itemId, quantity);
                    }
                });
            } else if (element.classList.contains('quantity-increase')) {
                element.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                    let quantity = parseInt(input.value) + 1;
                    if (quantity <= 99) {
                        updateCartItem(itemId, quantity);
                    }
                });
            } else {
                element.addEventListener('change', function() {
                    const itemId = this.getAttribute('data-item-id');
                    let quantity = parseInt(this.value);
                    if (quantity >= 1 && quantity <= 99) {
                        updateCartItem(itemId, quantity);
                    } else {
                        this.value = Math.min(Math.max(quantity, 1), 99);
                    }
                });
            }
        });
        
        // Remove item from cart
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id');
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    removeCartItem(itemId);
                }
            });
        });
        
        // Clear cart
        const clearCartBtn = document.getElementById('clearCartBtn');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear your entire cart?')) {
                    clearCart();
                }
            });
        }
        
        // Apply coupon
        const applyCouponBtn = document.getElementById('applyCouponBtn');
        if (applyCouponBtn) {
            applyCouponBtn.addEventListener('click', function() {
                const couponCode = document.getElementById('couponCode').value.trim();
                if (couponCode) {
                    applyCoupon(couponCode);
                }
            });
            
            // Enter key to apply coupon
            document.getElementById('couponCode').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const couponCode = this.value.trim();
                    if (couponCode) {
                        applyCoupon(couponCode);
                    }
                }
            });
        }
        
        // Remove coupon
        const removeCouponBtn = document.getElementById('removeCouponBtn');
        if (removeCouponBtn) {
            removeCouponBtn.addEventListener('click', function() {
                removeCoupon();
            });
        }
        
        // Checkout button
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function() {
                // Redirect to checkout page (to be implemented)
                window.location.href = "{{ route('user.checkout') }}";
            });
        }
        
        // Helper functions
        function updateCartItem(itemId, quantity) {
            fetch("{{ route('user.cart.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    menu_item_id: itemId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in navbar
                    updateCartCount(data.cart_count);
                    
                    // Update order summary
                    updateOrderSummary(data);
                    
                    // Update quantity input
                    document.querySelector(`.quantity-input[data-item-id="${itemId}"]`).value = quantity;
                    
                    // Show success message
                    showAlert('Cart updated successfully', 'success');
                } else {
                    showAlert(data.message || 'Failed to update cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            });
        }
        
        function removeCartItem(itemId) {
            fetch("{{ route('user.cart.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    menu_item_id: itemId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove item from DOM
                    document.querySelector(`.cart-item[data-item-id="${itemId}"]`)?.remove();
                    
                    // Update cart count in navbar
                    updateCartCount(data.cart_count);
                    
                    // Update order summary
                    updateOrderSummary(data);
                    
                    // Show success message
                    showAlert('Item removed from cart', 'success');
                    
                    // If cart is empty, reload page
                    if (data.cart_count === 0) {
                        setTimeout(() => location.reload(), 1000);
                    }
                } else {
                    showAlert(data.message || 'Failed to remove item', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            });
        }
        
        function clearCart() {
            fetch("{{ route('user.cart.clear') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in navbar
                    updateCartCount(0);
                    
                    // Show success message and reload
                    showAlert('Cart cleared successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(data.message || 'Failed to clear cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            });
        }
        
        function applyCoupon(couponCode) {
            const couponMessage = document.getElementById('couponMessage');
            couponMessage.textContent = 'Applying coupon...';
            couponMessage.className = 'text-info';
            
            fetch("{{ route('user.cart.apply-coupon') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    coupon_code: couponCode
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    couponMessage.textContent = data.message;
                    couponMessage.className = 'success';
                    
                    // Update order summary
                    updateOrderSummary({
                        subtotal: parseFloat(data.subtotal || document.getElementById('subtotalAmount').textContent.replace(/[^0-9.-]+/g,"")),
                        discount_amount: parseFloat(data.discount_amount || 0),
                        total: parseFloat(data.total)
                    });
                    
                    // Reload page to show coupon applied
                    setTimeout(() => location.reload(), 1500);
                } else {
                    couponMessage.textContent = data.message;
                    couponMessage.className = 'error';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                couponMessage.textContent = 'An error occurred. Please try again.';
                couponMessage.className = 'error';
            });
        }
        
        function removeCoupon() {
            fetch("{{ route('user.cart.remove-coupon') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to remove coupon
                    location.reload();
                } else {
                    showAlert('Failed to remove coupon', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            });
        }
        
        function updateOrderSummary(data) {
            if (data.subtotal !== undefined) {
                document.getElementById('subtotalAmount').textContent = `₦${parseFloat(data.subtotal).toFixed(2)}`;
            }
            if (data.tax_amount !== undefined) {
                document.getElementById('taxAmount').textContent = `₦${parseFloat(data.tax_amount).toFixed(2)}`;
            }
            if (data.delivery_fee !== undefined) {
                document.getElementById('deliveryFee').textContent = `₦${parseFloat(data.delivery_fee).toFixed(2)}`;
            }
            if (data.discount_amount !== undefined) {
                const discountElement = document.getElementById('discountAmount');
                if (discountElement) {
                    discountElement.textContent = `-₦${parseFloat(data.discount_amount).toFixed(2)}`;
                }
            }
            if (data.total !== undefined) {
                document.getElementById('totalAmount').textContent = `₦${parseFloat(data.total).toFixed(2)}`;
            }
        }
        
        function updateCartCount(count) {
            // Update cart count in navbar
            const cartBadge = document.querySelector('.badge-count');
            const cartIcon = document.querySelector('a[href="{{ route("user.cart") }}"]');
            
            if (count > 0) {
                if (cartBadge) {
                    cartBadge.textContent = count;
                } else if (cartIcon) {
                    const badge = document.createElement('span');
                    badge.className = 'badge-count';
                    badge.textContent = count;
                    cartIcon.appendChild(badge);
                }
            } else if (cartBadge) {
                cartBadge.remove();
            }
        }
        
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
            
            // Remove alert after 3 seconds
            setTimeout(() => {
                alert.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => alert.remove(), 300);
            }, 3000);
        }
        
        // Add CSS animations for alerts
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
        `;
        document.head.appendChild(style);
    });
</script>
@endpush
@endsection