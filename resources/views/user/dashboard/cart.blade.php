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
        <p class="text-muted mb-0">Review and customize your items before checkout</p>
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
                                <div class="cart-item border-bottom" data-item-id="{{ $item->menu_item_id }}" data-cart-item-id="{{ $item->id }}">
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
                                        <div class="col-9 col-md-5">
                                            <h6 class="mb-1">{{ $item->menuItem->name }}</h6>
                                            @if($item->menuItem->description)
                                                <p class="text-muted small mb-1">{{ Str::limit($item->menuItem->description, 50) }}</p>
                                            @endif
                                            <p class="mb-0 fw-semibold text-warning">
                                                ₦{{ number_format($item->menuItem->price, 2) }}
                                            </p>
                                            
                                            <!-- Display Add-ons -->
                                            @if($item->addons && $item->addons->count() > 0)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="bi bi-plus-circle me-1"></i>
                                                        Add-ons:
                                                        @foreach($item->addons as $addon)
                                                            {{ $addon->name }}{{ !$loop->last ? ', ' : '' }}
                                                        @endforeach
                                                    </small>
                                                </div>
                                            @endif
                                            
                                            <!-- Special Instructions -->
                                            @if($item->special_instructions)
                                                <div class="mt-1">
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
                                        
                                        <!-- Subtotal & Actions -->
                                        <div class="col-6 col-md-3 text-end mt-3 mt-md-0">
                                            <p class="mb-1 fw-semibold">
                                                ₦{{ number_format($item->menuItem->price * $item->quantity, 2) }}
                                            </p>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <!-- Customize Button -->
                                                <button class="btn btn-outline-warning btn-sm customize-cart-item"
                                                        data-cart-item-id="{{ $item->id }}"
                                                        data-menu-item-id="{{ $item->menu_item_id }}"
                                                        data-category="{{ strtolower($item->menuItem->category->name ?? '') }}">
                                                    <i class="bi bi-gear me-1"></i> Customize
                                                </button>
                                                
                                                <!-- Remove Button -->
                                                <button class="btn btn-link text-danger btn-sm remove-item"
                                                        data-item-id="{{ $item->menu_item_id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
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

<!-- ============================
     C U S T O M I Z A T I O N   M O D A L S
     ============================ -->

<!-- Single Customization Modal (Simplified) -->
<div class="modal fade" id="customizationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title" id="modalItemName">Customize Item</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="max-height: 400px; overflow-y: auto;">
                <!-- Item Image -->
                <div class="text-center p-3" id="modalItemImage">
                    <div class="placeholder-img bg-light rounded mx-auto" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cup-straw text-muted fs-1"></i>
                    </div>
                </div>
                
                <!-- Item Info -->
                <div class="px-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0" id="modalItemNameText"></h6>
                        <span class="fw-bold text-warning" id="modalItemPrice"></span>
                    </div>
                    <p class="text-muted small mb-3" id="modalItemDesc"></p>
                </div>
                
                <div class="px-3">
                    <!-- Quantity Controls -->
                    <div class="mb-4">
                        <label class="form-label text-warning fw-semibold">Quantity</label>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" id="modalQtyMinus">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="text" class="form-control text-center mx-2" id="modalQtyInput" value="1" style="width: 60px;">
                            <button class="btn btn-outline-secondary btn-sm" id="modalQtyPlus">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Add-ons Section -->
                    <div class="mb-4">
                        <label class="form-label text-warning fw-semibold">Add-ons</label>
                        <div id="modalAddonsList" class="bg-light rounded p-2" style="max-height: 200px; overflow-y: auto;">
                            <!-- Addons will be dynamically inserted here -->
                        </div>
                    </div>
                    
                    <!-- Preferences Section (Dynamic) -->
                    <div class="mb-4" id="modalPreferencesSection">
                        <label class="form-label text-warning fw-semibold">Preferences</label>
                        <div id="modalPreferencesList" class="bg-light rounded p-2">
                            <!-- Preferences will be dynamically inserted here -->
                        </div>
                    </div>
                    
                    <!-- Special Instructions -->
                    <div class="mb-4">
                        <label class="form-label text-warning fw-semibold">Special Instructions</label>
                        <textarea class="form-control form-control-sm" id="modalSpecialInstructions" rows="2" placeholder="Any special requests..."></textarea>
                    </div>
                    
                    <!-- Total Price -->
                    <div class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded">
                        <span>Total:</span>
                        <span class="fw-bold fs-5 text-warning" id="modalTotalPrice">₦0.00</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="modalUpdateBtn">
                    <i class="bi bi-check-circle me-1"></i>
                    Update Item
                </button>
            </div>
        </div>
    </div>
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
    
    .customize-cart-item {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
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
    
    /* Modal Fixes */
    .modal {
        z-index: 1060 !important;
    }
    
    .modal-backdrop {
        z-index: 1050 !important;
    }
    
    /* Hide backdrop if it's causing issues */
    body.modal-open .modal-backdrop {
        background-color: rgba(0,0,0,0.5);
    }
    
    /* Make modal smaller */
    .modal-sm {
        max-width: 450px;
    }
    
    /* Addon item styling */
    .addon-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    
    .addon-item:last-child {
        border-bottom: none;
    }
    
    .addon-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .addon-qty {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 2px;
    }
    
    .qty-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        background: white;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .qty-btn:hover {
        background: #f8f9fa;
    }
    
    /* Checkbox styling */
    .form-check {
        margin-bottom: 5px;
    }
    
    .form-check-input:checked {
        background-color: #ffc107;
        border-color: #ffc107;
    }
    
    /* Responsive */
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
        
        .customize-cart-item {
            font-size: 0.75rem;
            padding: 0.2rem 0.4rem;
        }
        
        .modal-sm {
            max-width: 95%;
            margin: 10px auto;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Store current cart item being customized
        let currentCartItemId = null;
        let currentMenuItemId = null;
        let currentCategory = null;
        let currentItemPrice = 0;
        
        // Helper functions
        function formatPrice(n) {
            return '₦' + new Intl.NumberFormat().format(n.toFixed(2));
        }
        
        function parsePrice(display) {
            if (!display) return 0;
            return Number(String(display).replace(/[^0-9.]/g, '') || 0);
        }
        
        // Fetch item data with add-ons
        async function fetchItem(id) {
            const res = await fetch(`/menu/item/${id}`);
            if (!res.ok) throw new Error('Item not found');
            return await res.json();
        }
        
        // Show alert
        function showAlert(message, type) {
            const existingAlert = document.querySelector('.custom-alert');
            if (existingAlert) existingAlert.remove();
            
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
            
            setTimeout(() => {
                alert.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => alert.remove(), 300);
            }, 3000);
        }
        
        // Customize cart item
        document.querySelectorAll('.customize-cart-item').forEach(btn => {
            btn.addEventListener('click', async () => {
                const cartItemId = btn.dataset.cartItemId;
                const menuItemId = btn.dataset.menuItemId;
                const category = (btn.dataset.category || '').toLowerCase();
                
                currentCartItemId = cartItemId;
                currentMenuItemId = menuItemId;
                currentCategory = category;
                
                try {
                    const item = await fetchItem(menuItemId);
                    currentItemPrice = parseFloat(item.price) || 0;
                    
                    populateModal(item, category);
                    
                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('customizationModal'));
                    modal.show();
                    
                } catch (err) {
                    console.error(err);
                    showAlert('Could not load item details. Please try again.', 'error');
                }
            });
        });
        
        // Populate modal
        function populateModal(item, category) {
            // Set basic info
            document.getElementById('modalItemName').textContent = `Customize ${item.name}`;
            document.getElementById('modalItemNameText').textContent = item.name;
            document.getElementById('modalItemPrice').textContent = formatPrice(currentItemPrice);
            document.getElementById('modalItemDesc').textContent = item.description || '';
            
            // Set image if available
            const imageContainer = document.getElementById('modalItemImage');
            if (item.image) {
                imageContainer.innerHTML = `
                    <img src="/storage/${item.image}" 
                         alt="${item.name}" 
                         class="img-fluid rounded" 
                         style="max-height: 120px; object-fit: cover;">
                `;
            } else {
                imageContainer.innerHTML = `
                    <div class="placeholder-img bg-light rounded mx-auto" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-${category.includes('drink') ? 'cup-straw' : 'egg-fried'} text-muted fs-1"></i>
                    </div>
                `;
            }
            
            // Set quantity to 1
            document.getElementById('modalQtyInput').value = 1;
            
            // Populate add-ons
            const addonsList = document.getElementById('modalAddonsList');
            addonsList.innerHTML = '';
            
            if (item.addons && item.addons.length > 0) {
                item.addons.forEach(addon => {
                    const addonPrice = parseFloat(addon.price || addon.additional_price || 0);
                    const addonItem = document.createElement('div');
                    addonItem.className = 'addon-item';
                    addonItem.innerHTML = `
                        <div>
                            <span class="fw-semibold">${addon.name}</span>
                            <br>
                            <small class="text-muted">+ ${formatPrice(addonPrice)}</small>
                        </div>
                        <div class="addon-controls">
                            <button type="button" class="qty-btn addon-minus" data-price="${addonPrice}">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="text" class="addon-qty" value="0" data-price="${addonPrice}" data-id="${addon.id}">
                            <button type="button" class="qty-btn addon-plus" data-price="${addonPrice}">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    `;
                    addonsList.appendChild(addonItem);
                });
            } else {
                addonsList.innerHTML = '<div class="text-center text-muted py-3">No add-ons available</div>';
            }
            
            // Populate preferences based on category
            const prefsSection = document.getElementById('modalPreferencesSection');
            const prefsList = document.getElementById('modalPreferencesList');
            prefsList.innerHTML = '';
            
            let preferences = [];
            if (category.includes('drink')) {
                preferences = [
                    { id: 'less_ice', label: 'Less ice' },
                    { id: 'no_ice', label: 'No ice' },
                    { id: 'extra_lemon', label: 'Extra lemon' }
                ];
            } else if (category.includes('grill')) {
                preferences = [
                    { id: 'no_onion', label: 'No onion' },
                    { id: 'no_veg', label: 'No vegetables' },
                    { id: 'well_done', label: 'Well done' },
                    { id: 'extra_sauce', label: 'Extra sauce' }
                ];
            } else {
                preferences = [
                    { id: 'no_onion', label: 'No onion' },
                    { id: 'no_crayfish', label: 'No crayfish' },
                    { id: 'extra_spicy', label: 'Extra spicy' }
                ];
            }
            
            preferences.forEach(pref => {
                const checkDiv = document.createElement('div');
                checkDiv.className = 'form-check';
                checkDiv.innerHTML = `
                    <input class="form-check-input" type="checkbox" id="pref_${pref.id}">
                    <label class="form-check-label" for="pref_${pref.id}">${pref.label}</label>
                `;
                prefsList.appendChild(checkDiv);
            });
            
            // Clear special instructions
            document.getElementById('modalSpecialInstructions').value = '';
            
            // Recalculate total
            recalculateModalTotal();
        }
        
        // Quantity controls
        document.getElementById('modalQtyMinus').addEventListener('click', function() {
            const input = document.getElementById('modalQtyInput');
            let value = parseInt(input.value) || 1;
            if (value > 1) {
                input.value = value - 1;
                recalculateModalTotal();
            }
        });
        
        document.getElementById('modalQtyPlus').addEventListener('click', function() {
            const input = document.getElementById('modalQtyInput');
            let value = parseInt(input.value) || 1;
            if (value < 99) {
                input.value = value + 1;
                recalculateModalTotal();
            }
        });
        
        document.getElementById('modalQtyInput').addEventListener('input', function() {
            let value = parseInt(this.value) || 1;
            if (value < 1) value = 1;
            if (value > 99) value = 99;
            this.value = value;
            recalculateModalTotal();
        });
        
        // Addon controls
        document.getElementById('modalAddonsList').addEventListener('click', function(e) {
            if (e.target.closest('.addon-minus')) {
                const btn = e.target.closest('.addon-minus');
                const input = btn.parentElement.querySelector('.addon-qty');
                let value = parseInt(input.value) || 0;
                if (value > 0) {
                    input.value = value - 1;
                    recalculateModalTotal();
                }
            }
            
            if (e.target.closest('.addon-plus')) {
                const btn = e.target.closest('.addon-plus');
                const input = btn.parentElement.querySelector('.addon-qty');
                let value = parseInt(input.value) || 0;
                input.value = value + 1;
                recalculateModalTotal();
            }
        });
        
        // Addon input change
        document.getElementById('modalAddonsList').addEventListener('input', function(e) {
            if (e.target.classList.contains('addon-qty')) {
                let value = parseInt(e.target.value) || 0;
                if (value < 0) value = 0;
                e.target.value = value;
                recalculateModalTotal();
            }
        });
        
        // Recalculate total
        function recalculateModalTotal() {
            const quantity = parseInt(document.getElementById('modalQtyInput').value) || 1;
            
            // Base item total
            let total = currentItemPrice * quantity;
            
            // Add add-ons
            document.querySelectorAll('.addon-qty').forEach(input => {
                const qty = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price) || 0;
                total += qty * price;
            });
            
            // Update display
            document.getElementById('modalTotalPrice').textContent = formatPrice(total);
        }
        
        // Update cart item
        document.getElementById('modalUpdateBtn').addEventListener('click', function() {
            if (!currentCartItemId) {
                showAlert('No item selected for update', 'error');
                return;
            }
            
            const quantity = parseInt(document.getElementById('modalQtyInput').value) || 1;
            
            // Collect addons
            const addons = [];
            document.querySelectorAll('.addon-qty').forEach(input => {
                const qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    addons.push({
                        id: input.dataset.id,
                        quantity: qty
                    });
                }
            });
            
            // Collect preferences
            const preferences = [];
            document.querySelectorAll('#modalPreferencesList .form-check-input:checked').forEach(checkbox => {
                const label = checkbox.closest('.form-check').querySelector('.form-check-label').textContent;
                preferences.push(label);
            });
            
            // Get special instructions
            const specialInstructions = document.getElementById('modalSpecialInstructions').value.trim();
            
            // Build payload
            const payload = {
                cart_item_id: currentCartItemId,
                quantity: quantity,
                addons: addons,
                preferences: preferences,
                special_instructions: specialInstructions
            };
            
            // Show loading
            const btn = this;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-1"></i> Updating...';
            
            // Send request
            fetch('/my-account/cart/update-item', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('customizationModal'));
                    if (modal) modal.hide();
                    
                    // Show success and reload
                    showAlert('Item updated successfully!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(data.message || 'Failed to update item', 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
        
        // ================================
        // Original cart functionality (keep)
        // ================================
        
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
                    updateCartCount(data.cart_count);
                    updateOrderSummary(data);
                    document.querySelector(`.quantity-input[data-item-id="${itemId}"]`).value = quantity;
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
        
        // Remove item from cart
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id');
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    removeCartItem(itemId);
                }
            });
        });
        
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
                    document.querySelector(`.cart-item[data-item-id="${itemId}"]`)?.remove();
                    updateCartCount(data.cart_count);
                    updateOrderSummary(data);
                    showAlert('Item removed from cart', 'success');
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
        
        // Clear cart
        const clearCartBtn = document.getElementById('clearCartBtn');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear your entire cart?')) {
                    clearCart();
                }
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
                    updateCartCount(0);
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
                    updateOrderSummary({
                        subtotal: parseFloat(data.subtotal || document.getElementById('subtotalAmount').textContent.replace(/[^0-9.-]+/g,"")),
                        discount_amount: parseFloat(data.discount_amount || 0),
                        total: parseFloat(data.total)
                    });
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
        
        // Remove coupon
        const removeCouponBtn = document.getElementById('removeCouponBtn');
        if (removeCouponBtn) {
            removeCouponBtn.addEventListener('click', function() {
                removeCoupon();
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
        
        // Checkout button
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function() {
                window.location.href = "{{ route('user.checkout') }}";
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
            .spin {
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
        
        // Recalculate total when modal opens
        document.getElementById('customizationModal').addEventListener('shown.bs.modal', function() {
            recalculateModalTotal();
        });
    });
</script>
@endpush
@endsection