@extends('layouts.user-dashboard-clean')

@section('title', 'My Wishlist - Demanchys Lounge')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-2 text-muted">My Wishlist</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Wishlist</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                @if($wishlistItems->count() > 0)
                    <button type="button" onclick="clearWishlist()" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i> Clear All
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Wishlist Statistics -->
    @if($wishlistItems->count() > 0)
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-heart fs-4" style="color: #ffc107;"></i>
                    </div>
                </div>
                <h4 class="mb-1 text-muted">{{ $wishlistItems->count() }}</h4>
                <p class="text-muted mb-0">Total Items</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(25, 135, 84, 0.1);">
                        <i class="bi bi-currency-dollar fs-4" style="color: #198754;"></i>
                    </div>
                </div>
                <h4 class="mb-1 text-muted">₦{{ number_format($totalValue, 2) }}</h4>
                <p class="text-muted mb-0">Total Value</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(13, 110, 253, 0.1);">
                        <i class="bi bi-cart-check fs-4" style="color: #0d6efd;"></i>
                    </div>
                </div>
                @php
                    $availableItems = $wishlistItems->filter(function($item) {
                        return $item->menuItem && $item->menuItem->is_available;
                    })->count();
                @endphp
                <h4 class="mb-1 text-muted">{{ $availableItems }}</h4>
                <p class="text-muted mb-0">Available Now</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Wishlist Items -->
    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-muted">My Wishlisted Items</h4>
            <div class="text-muted">
                {{ $wishlistItems->count() }} item(s)
            </div>
        </div>

        @if($wishlistItems->count() > 0)
            <div class="row">
                @foreach($wishlistItems as $wishlistItem)
                @if($wishlistItem->menuItem)
                <div class="col-md-6 col-lg-4 mb-4 wishlist-item" data-id="{{ $wishlistItem->menu_item_id }}">
                    <div class="card border h-100">
                        <div class="card-body">
                            <!-- Item Image -->
                            <div class="position-relative mb-3">
                                <div class="wishlist-item-image" style="height: 200px; overflow: hidden; border-radius: 8px;">
                                    @if($wishlistItem->menuItem->image)
                                        <img src="{{ $wishlistItem->menuItem->image_url }}" 
                                             alt="{{ $wishlistItem->menuItem->name }}"
                                             class="img-fluid w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                            <i class="bi bi-image text-muted fs-1"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Availability Badge -->
                                @if(!$wishlistItem->menuItem->is_available)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-danger">Unavailable</span>
                                    </div>
                                @endif
                                
                                <!-- Remove Button -->
                                <div class="position-absolute top-0 start-0 m-2">
                                    <button type="button" onclick="removeFromWishlist({{ $wishlistItem->menu_item_id }})" 
                                            class="btn btn-sm btn-danger rounded-circle">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Item Details -->
                            <h5 class="card-title mb-2">{{ $wishlistItem->menuItem->name }}</h5>
                            
                            @if($wishlistItem->menuItem->description)
                                <p class="card-text small text-muted mb-2">
                                    {{ Str::limit($wishlistItem->menuItem->description, 80) }}
                                </p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="text-warning mb-0">₦{{ number_format($wishlistItem->menuItem->price, 2) }}</h5>
                                </div>
                                <div>
                                    @if($wishlistItem->menuItem->is_featured)
                                        <span class="badge bg-warning text-dark">Featured</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                @if($wishlistItem->menuItem->is_available)
                                    <button type="button" onclick="moveToCart({{ $wishlistItem->menu_item_id }})" 
                                            class="btn btn-warning">
                                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary" disabled>
                                        <i class="bi bi-cart-x me-1"></i> Currently Unavailable
                                    </button>
                                @endif
                                
                                <a href="{{ route('menu') }}?item={{ $wishlistItem->menuItem->id }}" 
                                   class="btn btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            
            <!-- Empty Wishlist Message (shown via JS) -->
            <div id="emptyWishlistMessage" class="text-center py-5 d-none">
                <i class="bi bi-heart fs-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">Your Wishlist is Empty</h4>
                <p class="text-muted mb-4">Save your favorite menu items here for easy access later.</p>
                <a href="{{ route('menu') }}" class="btn btn-warning">
                    <i class="bi bi-search me-1"></i> Browse Menu
                </a>
            </div>
        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-5">
                <i class="bi bi-heart fs-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">Your Wishlist is Empty</h4>
                <p class="text-muted mb-4">Save your favorite menu items here for easy access later.</p>
                <a href="{{ route('menu') }}" class="btn btn-warning">
                    <i class="bi bi-search me-1"></i> Browse Menu
                </a>
            </div>
        @endif
    </div>

    <!-- Recommendations -->
    @if($wishlistItems->count() > 0)
    @php
        // Get featured items that are not already in wishlist
        $wishlistIds = $wishlistItems->pluck('menu_item_id')->toArray();
        $recommendations = \App\Models\MenuItem::where('is_featured', true)
                                             ->where('is_available', true)
                                             ->whereNotIn('id', $wishlistIds)
                                             ->inRandomOrder()
                                             ->take(3)
                                             ->get();
    @endphp
    
    @if($recommendations->count() > 0)
    <div class="dashboard-card mt-4">
        <h4 class="mb-3 text-muted">
            <i class="bi bi-stars text-warning me-2"></i>
            You Might Also Like
        </h4>
        <div class="row">
            @foreach($recommendations as $item)
            <div class="col-md-4 mb-3">
                <div class="card border h-100">
                    <div class="card-body">
                        <div class="position-relative mb-3">
                            @if($item->image)
                                <img src="{{ $item->image_url }}" 
                                     alt="{{ $item->name }}"
                                     style="height: 150px; width: 100%; object-fit: cover; border-radius: 8px;">
                            @endif
                            <div class="position-absolute top-0 end-0 m-2">
                                <button type="button" onclick="addToWishlist({{ $item->id }})" 
                                        class="btn btn-sm btn-outline-danger rounded-circle">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                        <h6 class="card-title mb-2">{{ $item->name }}</h6>
                        <p class="card-text text-warning mb-2">₦{{ number_format($item->price, 2) }}</p>
                        <div class="d-grid">
                            <button type="button" onclick="addToWishlist({{ $item->id }})" 
                                    class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-heart me-1"></i> Add to Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endif
</div>

@push('scripts')
<script>
    // Add to wishlist function (for use on menu page)
    function addToWishlist(menuItemId) {
        $.ajax({
            url: '{{ route("user.wishlist.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                menu_item_id: menuItemId
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Update wishlist count in sidebar
                    updateWishlistCount(response.wishlist_count);
                    
                    // If on wishlist page, refresh
                    if (window.location.pathname.includes('wishlist')) {
                        window.location.reload();
                    }
                } else {
                    Swal.fire({
                        title: 'Info',
                        text: response.message,
                        icon: 'info',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function() {
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
    
    // Remove from wishlist
    function removeFromWishlist(menuItemId) {
        Swal.fire({
            title: 'Remove Item?',
            text: 'Are you sure you want to remove this item from your wishlist?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("my-account/wishlist/remove") }}/' + menuItemId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove item from DOM
                            $(`.wishlist-item[data-id="${menuItemId}"]`).remove();
                            
                            // Update wishlist count
                            updateWishlistCount(response.wishlist_count);
                            
                            // Show success message
                            Swal.fire({
                                title: 'Removed!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            // Check if wishlist is empty
                            if (response.wishlist_count === 0) {
                                $('.dashboard-card .row').hide();
                                $('#emptyWishlistMessage').removeClass('d-none');
                            }
                        }
                    },
                    error: function() {
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
    
    // Move to cart
    function moveToCart(menuItemId) {
        $.ajax({
            url: '{{ url("my-account/wishlist/move-to-cart") }}/' + menuItemId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Remove item from wishlist display
                    $(`.wishlist-item[data-id="${menuItemId}"]`).remove();
                    
                    // Update counts
                    updateWishlistCount(response.wishlist_count);
                    updateCartCount(response.cart_count);
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Check if wishlist is empty
                    if (response.wishlist_count === 0) {
                        $('.dashboard-card .row').hide();
                        $('#emptyWishlistMessage').removeClass('d-none');
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function() {
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
    
    // Clear all wishlist items
    function clearWishlist() {
        Swal.fire({
            title: 'Clear Wishlist?',
            text: 'Are you sure you want to remove all items from your wishlist?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, clear all',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("user.wishlist.clear") }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Hide all wishlist items
                            $('.wishlist-item').remove();
                            $('.row.mb-4').hide(); // Hide statistics
                            
                            // Show empty message
                            $('#emptyWishlistMessage').removeClass('d-none');
                            
                            // Update wishlist count
                            updateWishlistCount(0);
                            
                            Swal.fire({
                                title: 'Cleared!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
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
        const wishlistLinks = document.querySelectorAll('a[href*="/wishlist"], a[href*="wishlist"]');
        const countElements = document.querySelectorAll('.wishlist-count');

        wishlistLinks.forEach(link => {
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

        // Update textual counters
        countElements.forEach(el => el.textContent = count);
    }
    
    // Update cart count
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
        });
    }
</script>
@endpush

<style>
    .wishlist-item .card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .wishlist-item .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .wishlist-item-image {
        transition: transform 0.3s ease;
    }
    
    .wishlist-item .card:hover .wishlist-item-image {
        transform: scale(1.05);
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
    
    .object-fit-cover {
        object-fit: cover;
    }
    
    @media (max-width: 768px) {
        .wishlist-item-image {
            height: 150px !important;
        }
    }
</style>
@endsection