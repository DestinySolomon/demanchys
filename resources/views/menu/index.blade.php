@extends('layouts.app')

@section('content')
<style>
    /* -------------------------
       Menu styles
       ------------------------- */
    .container {
        margin-top: 0px;
        padding-top: 0px;
    }

    .menu-section-title {
        font-size: 28px;
        font-weight: 700;
        margin-top: 45px;
        margin-bottom: 20px;
        color: #f8f9fa;
        border-left: 5px solid #ffc107;
        padding-left: 10px;
    }

    .menu-card {
        background: #1b1b1b;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.4);
        transition: transform .2s;
        height: 100%;
        position: relative;
    }

    .menu-card:hover {
        transform: translateY(-4px);
    }

    .menu-card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .menu-card-body {
        padding: 20px;
        width: 100%;
    }

    .availability-tag {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 30px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .daily {
        background: #198754;
        color: #fff;
    }

    .ondemand {
        background: #0d6efd;
        color: #fff;
    }

    .menu-item-name {
        font-size: 19px;
        font-weight: 700;
        color: #fff;
    }

    .menu-item-description {
        color: #ccc;
        font-size: 14px;
        margin-top: 6px;
    }

    .menu-item-price {
        color: #ffc107;
        font-weight: 700;
        font-size: 20px;
        margin-top: 12px;
    }

    .modal-backdrop {
        display: none !important;
    }

    .btn-custom {
        background: #ffc107;
        border: none;
        color: #000;
        font-weight: 600;
    }

    .btn-outline-custom {
        border: 2px solid #ffc107;
        color: #ffc107;
        font-weight: 600;
        font-size: 15px;
    }

    .btn-outline-custom:hover {
        background: #ffc107;
        color: #000;
    }

    .modal-content {
        background: #111;
        color: white;
        border-radius: 10px;
    }

    .addon-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }

    .addon-controls {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .addon-qty {
        width: 46px;
        text-align: center;
        background: transparent;
        color: white;
        border: none;
    }

    .qty-controls {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .small-muted {
        color: #bfbfbf;
        font-size: 13px;
    }

    .modal-sm-custom {
        max-width: 520px;
    }

    /* REMOVED: Delivery type CSS styles */

    /* Make custom small modal */
    .modal-sm-custom .modal-content {
        max-width: 660px;
        margin: 0 auto;
        border-radius: 12px;
    }

    /* Allow smooth scroll inside the modal body */
    .modal-dialog-scrollable .modal-body {
        max-height: 40vh;
        overflow-y: auto;
    }

    /* Optional: reduce padding inside modal */
    .modal-sm-custom .modal-content {
        padding: 10px !important;
    }

    /* Make header compact */
    .modal-sm-custom .modal-header {
        padding: 8px 12px !important;
    }

    /* Wishlist button styles */
    .wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        z-index: 10;
        background: rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .wishlist-btn:hover {
        background: rgba(0, 0, 0, 0.8);
        transform: scale(1.1);
    }

    .wishlist-btn i {
        font-size: 18px;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #b02a37;
    }

    /* Image container for positioning */
    .image-container {
        position: relative;
        width: 100%;
        height: 160px;
        overflow: hidden;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .menu-card:hover .image-container img {
        transform: scale(1.05);
    }

    /* Fix huge empty space under navbar on mobile */
    @media (max-width: 576px) {
        body {
            padding-top: 70px !important;
        }

        .menu-section-title {
            margin-top: 10px !important;
        }

        .image-container {
            height: 120px;
        }

        .menu-item-name {
            font-size: 16px !important;
        }

        .menu-item-description {
            font-size: 12px !important;
        }

        .menu-item-price {
            font-size: 16px !important;
        }

        .wishlist-btn {
            width: 32px;
            height: 32px;
            top: 8px;
            right: 8px;
        }

        .wishlist-btn i {
            font-size: 16px;
        }

        .btn-outline-custom {
            font-size: 13px;
            padding: 6px 12px;
        }
    }

    @media (max-width: 576px) {
        .modal-sm-custom {
            max-width: 92%;
        }
    }

    /* Toast notification styles */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideIn 0.3s ease;
    }

    .toast-notification.error {
        background: #dc3545;
    }

    .toast-notification.warning {
        background: #ffc107;
        color: #000;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>

<div class="container py-1 pt-0">
    @foreach($categories as $category)
        <h2 class="menu-section-title">{{ $category->name }}</h2>

        <div class="row g-4 mb-5">
            @forelse($category->items as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="menu-card">
                        <!-- Image Container with Wishlist Button -->
                        <div class="image-container">
                            <img src="{{ $item->image_url ?? asset('assets/placeholder_food.jpg') }}" alt="{{ $item->name }}">
                            
                            <!-- Wishlist Button (Top Right Corner) -->
                            @auth
                            <button type="button" onclick="addToWishlist({{ $item->id }})" 
                                    class="btn btn-outline-danger wishlist-btn"
                                    title="Add to Wishlist"
                                    data-item-id="{{ $item->id }}"
                                    id="wishlist-btn-{{ $item->id }}">
                                <i class="bi bi-heart"></i>
                            </button>
                            @endauth
                        </div>
                        
                        <div class="menu-card-body">
                            @if(!empty($item->availability))
                                <span class="availability-tag {{ strtolower($item->availability) === 'daily' ? 'daily' : 'ondemand' }}">
                                    {{ $item->availability }}
                                </span>
                            @endif

                            <div class="menu-item-name">{{ $item->name }}</div>
                            <div class="menu-item-description">{{ \Illuminate\Support\Str::limit($item->description ?? '', 120) }}</div>
                            <div class="menu-item-price">₦{{ number_format($item->price) }}</div>

                            <div class="d-flex gap-2 mt-3">
                                <!-- Add to Cart Button (Updated) -->
                                <button class="btn btn-outline-custom w-100 add-to-cart-btn"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-price="{{ $item->price }}"
                                        data-image="{{ $item->image_url ?? asset('assets/placeholder_food.jpg') }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light">No items in this category yet.</div>
                </div>
            @endforelse
        </div>
    @endforeach
</div>

<!-- ============================
     C O M M O N   M O D A L S
     ============================ -->

<!-- REMOVED: All customization modals (Cuisine, Drinks, Grill) -->
<!-- These will be moved to the cart page instead -->

@push('scripts')
<script>
// Wait for jQuery to be ready
$(document).ready(function() {
    console.log('jQuery loaded and ready');
    
    // Your existing wishlist JavaScript goes here
    function addToWishlist(menuItemId) {
        console.log('Adding to wishlist:', menuItemId);
        
        const btn = document.getElementById(`wishlist-btn-${menuItemId}`);
        if (!btn) return;
        
        // Show loading state
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-heart-half"></i>';
        btn.disabled = true;
        
        $.ajax({
            url: '{{ route("user.wishlist.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                menu_item_id: menuItemId
            },
            success: function(response) {
                console.log('Response:', response);
                
                if (response.success) {
                    // Update button
                    btn.innerHTML = '<i class="bi bi-heart-fill"></i>';
                    btn.classList.remove('btn-outline-danger');
                    btn.classList.add('btn-danger');
                    btn.setAttribute('onclick', `removeFromWishlistMenu(${menuItemId})`);
                    btn.setAttribute('title', 'Remove from Wishlist');
                    btn.disabled = false;
                    
                    // Show success
                    Swal.fire({
                        title: 'Added!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                    Swal.fire({
                        title: 'Already in Wishlist',
                        text: response.message,
                        icon: 'info',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                btn.innerHTML = originalHTML;
                btn.disabled = false;
                
                if (xhr.status === 401) {
                    Swal.fire({
                        title: 'Login Required',
                        text: 'Please login to add items to wishlist',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Login',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("login") }}';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong',
                        icon: 'error',
                        timer: 2000
                    });
                }
            }
        });
    }
    
    // Make function available globally
    window.addToWishlist = addToWishlist;
    
    console.log('Wishlist system initialized with jQuery');
});

document.addEventListener('DOMContentLoaded', function () {
    // Helper function to show toast notifications
    function showToast(message, type = 'success', duration = 3000) {
        // Remove existing toast
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => existingToast.remove(), 300);
        }
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
            <i class="bi ${type === 'success' ? 'bi-check-circle' : type === 'error' ? 'bi-exclamation-circle' : 'bi-info-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after duration
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    // Helper function to update cart count in navbar
    function updateCartCount(count) {
        // Find cart badge in navbar
        const cartBadge = document.querySelector('.cart-badge, .badge.bg-warning, [href*="cart"] .badge');
        if (cartBadge) {
            if (count > 0) {
                cartBadge.textContent = count;
                cartBadge.style.display = 'inline-block';
            } else {
                cartBadge.style.display = 'none';
            }
        }
        
        // Also update any other cart count indicators
        const cartCounts = document.querySelectorAll('.cart-count');
        cartCounts.forEach(el => {
            el.textContent = count;
        });
    }

    // Add to Cart functionality
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.id;
            const itemName = this.dataset.name;
            const itemPrice = this.dataset.price;
            
            console.log('Adding to cart:', { itemId, itemName, itemPrice });
            
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Adding...';
            this.disabled = true;
            
            // Get CSRF token
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            // Prepare payload - simple add to cart without customization
            const payload = {
                menu_item_id: itemId,
                quantity: 1,
                addons: [],
                preferences: [],
                special_instructions: ''
            };
            
            // Add to cart via AJAX
            fetch('/my-account/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Add to cart response:', data);
                
                if (data.success) {
                    // Show success toast
                    showToast(`Added ${itemName} to cart!`, 'success');
                    
                    // Update cart count
                    if (data.cart_count !== undefined) {
                        updateCartCount(data.cart_count);
                    }
                    
                    // Optional: Show "View Cart" button for a moment
                    setTimeout(() => {
                        // Restore button
                        this.innerHTML = originalText;
                        this.disabled = false;
                        
                        // Optional: Change button to "View Cart" temporarily
                        this.innerHTML = '<i class="bi bi-cart-check"></i> View Cart';
                        this.classList.remove('btn-outline-custom');
                        this.classList.add('btn-custom');
                        
                        // Revert after 3 seconds
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.classList.remove('btn-custom');
                            this.classList.add('btn-outline-custom');
                        }, 3000);
                    }, 1000);
                } else {
                    // Show error
                    showToast(data.message || 'Failed to add to cart', 'error');
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });

    // Add spin animation for loading
    if (!document.getElementById('spin-animation')) {
        const style = document.createElement('style');
        style.id = 'spin-animation';
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .bi-arrow-clockwise.spin {
                animation: spin 1s linear infinite;
                display: inline-block;
            }
        `;
        document.head.appendChild(style);
    }

    // ============================================
    // W I S H L I S T   F U N C T I O N A L I T Y
    // ============================================

    // Wishlist functionality (kept as is)
    function addToWishlist(menuItemId) {
        const btn = document.getElementById(`wishlist-btn-${menuItemId}`);
        if (!btn) return;
        
        // Show loading state
        const originalHTML = btn.innerHTML;
        const originalClass = btn.className;
        btn.innerHTML = '<i class="bi bi-heart-half"></i>';
        btn.className = 'wishlist-btn btn btn-secondary';
        btn.disabled = true;
        
        $.ajax({
            url: '{{ route("user.wishlist.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                menu_item_id: menuItemId
            },
            success: function(response) {
                if (response.success) {
                    // Update button to show "in wishlist" state
                    btn.innerHTML = '<i class="bi bi-heart-fill"></i>';
                    btn.className = 'wishlist-btn btn btn-danger';
                    btn.setAttribute('onclick', `removeFromWishlistMenu(${menuItemId})`);
                    btn.setAttribute('title', 'Remove from Wishlist');
                    btn.disabled = false;
                    
                    // Show success message
                    Swal.fire({
                        title: 'Added to Wishlist!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Update wishlist count in sidebar
                    updateWishlistCount(response.wishlist_count);
                } else {
                    // Already in wishlist
                    btn.innerHTML = '<i class="bi bi-heart-fill"></i>';
                    btn.className = 'wishlist-btn btn btn-danger';
                    btn.setAttribute('onclick', `removeFromWishlistMenu(${menuItemId})`);
                    btn.setAttribute('title', 'Remove from Wishlist');
                    btn.disabled = false;
                    
                    Swal.fire({
                        title: 'Already in Wishlist',
                        text: response.message,
                        icon: 'info',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                // Restore original state
                btn.innerHTML = originalHTML;
                btn.className = originalClass;
                btn.disabled = false;
                
                if (xhr.status === 401) {
                    // Not authenticated
                    Swal.fire({
                        title: 'Login Required',
                        text: 'Please login to add items to your wishlist',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Login',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("login") }}';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            }
        });
    }

    // Remove from wishlist (for menu page)
    function removeFromWishlistMenu(menuItemId) {
        const btn = document.getElementById(`wishlist-btn-${menuItemId}`);
        if (!btn) return;
        
        Swal.fire({
            title: 'Remove from Wishlist?',
            text: 'Are you sure you want to remove this item from your wishlist?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-heart-half"></i>';
                btn.disabled = true;
                
                $.ajax({
                    url: '{{ route("user.wishlist.remove", "") }}/' + menuItemId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update button appearance
                            btn.innerHTML = '<i class="bi bi-heart"></i>';
                            btn.className = 'wishlist-btn btn btn-outline-danger';
                            btn.setAttribute('onclick', `addToWishlist(${menuItemId})`);
                            btn.setAttribute('title', 'Add to Wishlist');
                            btn.disabled = false;
                            
                            // Update wishlist count
                            updateWishlistCount(response.wishlist_count);
                            
                            Swal.fire({
                                title: 'Removed!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    }

    // Update wishlist count across navbar, mobile and sidebar
    function updateWishlistCount(count) {
        // Find all links that point to wishlist (desktop/mobile/sidebar)
        const wishlistLinks = document.querySelectorAll('a[href*="/wishlist"], a[href*="wishlist"]');

        wishlistLinks.forEach(link => {
            // Try navbar style badge (.badge-count) first
            let badge = link.querySelector('.badge-count') || link.querySelector('.badge');

            if (count > 0) {
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = badge.classList.contains('badge-count') ? 'flex' : 'inline-block';
                } else {
                    const newBadge = document.createElement('span');
                    if (link.classList.contains('nav-icon-btn') || link.classList.contains('mobile-icon')) {
                        newBadge.className = 'badge-count';
                        newBadge.style.display = 'flex';
                    } else {
                        newBadge.className = 'badge bg-warning ms-auto';
                        newBadge.style.display = 'inline-block';
                    }
                    newBadge.textContent = count;
                    link.appendChild(newBadge);
                }
            } else {
                if (badge) badge.style.display = 'none';
            }
        });

        // Update any textual counters
        const textCounters = document.querySelectorAll('.wishlist-count');
        textCounters.forEach(el => el.textContent = count);
    }

    // Check wishlist status on page load
    document.addEventListener('DOMContentLoaded', function() {
        @auth
        // Optional: Check which items are already in wishlist and update buttons
        // This would require an additional API endpoint to get user's wishlist items
        // For now, buttons will update when clicked
        @endauth
    });
});

// Make addToWishlist globally available
window.addToWishlist = addToWishlist;
</script>
@endpush

@endsection