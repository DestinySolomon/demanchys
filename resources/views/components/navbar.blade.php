<style>
    /* Navbar styles to match dashboard */
    .navbar-dashboard {
        background: #1a1a1a !important;
        height: 80px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .user-nav-icons {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .nav-icon-btn {
        position: relative;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.12);
        color: white;
        transition: all 0.3s;
    }

    .nav-icon-btn:hover {
        background: rgba(255,255,255,0.06);
        color: #ffc107;
        border-color: #ffc107;
    }

    .badge-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mobile-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.12);
        color: white;
        transition: all 0.3s;
        position: relative; /* ensure badge positions relative to the icon on mobile */
    }

    .mobile-icon:hover {
        background: rgba(255,255,255,0.06);
        color: #ffc107;
        border-color: #ffc107;
    }

    .mobile-hamburger {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.12);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .mobile-hamburger:hover {
        background: rgba(255,255,255,0.06);
        color: #ffc107;
        border-color: #ffc107;
    }

    /* Tweak badge placement on small screens so it hugs the icon */
    @media (max-width: 576px) {
        .badge-count {
            top: -6px;
            right: -6px;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
        }
    }

    .user-dropdown-toggle {
        background: none;
        border: 1px solid rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.4rem 0.85rem;
        border-radius: 25px;
        transition: all 0.3s;
        color: white;
    }

    .user-dropdown-toggle:hover {
        background: rgba(255,255,255,0.06);
        border-color: #ffc107;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-avatar-initials {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .user-dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 10px;
        padding: 0.5rem 0;
        min-width: 220px;
    }

    .user-dropdown-item {
        padding: 0.6rem 1.2rem;
        color: #333;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.2s;
    }

    .user-dropdown-item:hover {
        background: #f8f9fa;
        color: #ffc107;
    }

    .user-dropdown-item i {
        width: 20px;
        margin-right: 10px;
        font-size: 1rem;
    }
</style>

<!-- TOP NAVBAR - Shared across all layouts -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-dashboard">
    <div class="container">
        <!-- Logo Left -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            @php
                $logoUrl = null;
                if (!empty($settings['logo'])) {
                    $logoUrl = \Illuminate\Support\Facades\Storage::url($settings['logo']);
                }
            @endphp
            <img src="{{ ($logoUrl ? $logoUrl . '?v=' . ($settings_version ?? time()) : asset('assets/logo.png')) }}" 
                 alt="{{ $settings['site_name'] ?? 'De Manchys Lounge' }}" 
                 height="40">
        </a>
        
        <!-- Mobile Icons (right side) -->
        <div class="d-flex d-lg-none align-items-center gap-2">
            @auth
                <!-- Heart Icon (Mobile) -->
                <a href="{{ route('user.wishlist') }}" class="mobile-icon" title="Wishlist">
                    <i class="bi bi-heart"></i>
                    @php
                        $wishlistCount = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0;
                    @endphp
                    @if($wishlistCount > 0)
                        <span class="badge-count">{{ $wishlistCount }}</span>
                    @endif
                </a>
                
                <!-- Cart Icon (Mobile) -->
                <a href="{{ route('user.cart') }}" class="mobile-icon" title="Cart">
                    <i class="bi bi-cart3"></i>
                    @php
                        $cartCount = 0;
                        if (auth()->check()) {
                            $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                        } else {
                            $cart = session()->get('cart', []);
                            $cartCount = $cart ? array_sum(array_column($cart, 'quantity')) : 0;
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span class="badge-count">{{ $cartCount }}</span>
                    @endif
                </a>
            @endauth
            
            <!-- Hamburger for Top Nav Menu (Mobile only) -->
            <button class="mobile-hamburger" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#topNavMenu">
                <i class="bi bi-list"></i>
            </button>
        </div>
        
        <!-- Center Menu (Desktop only) -->
        <div class="d-none d-lg-flex justify-content-center flex-grow-1">
            <ul class="navbar-nav d-flex flex-row gap-4">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('home') ? 'active text-warning fw-bold' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('about') ? 'active text-warning fw-bold' : '' }}"
                       href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('menu') ? 'active text-warning fw-bold' : '' }}"
                       href="{{ route('menu') }}">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('events.*') ? 'active text-warning fw-bold' : '' }}"
                       href="{{ route('events.index') }}">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('contact') ? 'active text-warning fw-bold' : '' }}"
                       href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
        </div>
        
        <!-- User Icons Right (Desktop only) -->
        <div class="user-nav-icons d-none d-lg-flex">
            @auth
                @php
                    // Calculate counts for both wishlist and cart
                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                    $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                @endphp
                
                <!-- Desktop: Heart, Cart, User Dropdown -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Wishlist Icon -->
                    <a href="{{ route('user.wishlist') }}" class="nav-icon-btn" title="Wishlist">
                        <i class="bi bi-heart"></i>
                        @if($wishlistCount > 0)
                            <span class="badge-count">{{ $wishlistCount }}</span>
                        @endif
                    </a>
                    
                    <!-- Cart Icon -->
                    <a href="{{ route('user.cart') }}" class="nav-icon-btn" title="Cart">
                        <i class="bi bi-cart3"></i>
                        @if($cartCount > 0)
                            <span class="badge-count">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    <!-- User Dropdown (Desktop only) -->
                    <div class="dropdown">
                        <button class="user-dropdown-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->profile_image)
                                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                                     alt="Profile" 
                                     class="user-avatar">
                            @else
                                <div class="user-avatar-initials">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu user-dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('user.dashboard') }}" class="user-dropdown-item">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.edit-profile') }}" class="user-dropdown-item">
                                    <i class="bi bi-person"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.orders') }}" class="user-dropdown-item">
                                    <i class="bi bi-bag"></i> My Orders
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.bookings') }}" class="user-dropdown-item">
                                    <i class="bi bi-calendar-check"></i> My Bookings
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.reviews') }}" class="user-dropdown-item">
                                    <i class="bi bi-star"></i> My Reviews
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.cart') }}" class="user-dropdown-item">
                                    <i class="bi bi-cart3"></i> My Cart
                                    @if($cartCount > 0)
                                        <span class="badge bg-warning ms-auto">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="user-dropdown-item w-100 text-start border-0 bg-transparent">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <!-- Guest buttons (Desktop only) -->
                @php
                    // For guests, check session cart
                    $cart = session()->get('cart', []);
                    $guestCartCount = $cart ? array_sum(array_column($cart, 'quantity')) : 0;
                @endphp
                
                <!-- Cart Icon for Guests -->
                @if($guestCartCount > 0)
                    <a href="{{ route('user.cart') }}" class="nav-icon-btn" title="Cart">
                        <i class="bi bi-cart3"></i>
                        <span class="badge-count">{{ $guestCartCount }}</span>
                    </a>
                @endif
                
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-warning">Sign Up</a>
            @endauth
        </div>
    </div>
    
    <!-- Mobile Top Nav Menu (collapsible) -->
    <div class="container-fluid d-lg-none">
        <div class="collapse mt-2" id="topNavMenu">
            <div class="card card-body bg-dark">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('home') ? 'active text-warning fw-bold' : '' }}"
                           href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('about') ? 'active text-warning fw-bold' : '' }}"
                           href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('menu') ? 'active text-warning fw-bold' : '' }}"
                           href="{{ route('menu') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('events.*') ? 'active text-warning fw-bold' : '' }}"
                           href="{{ route('events.index') }}">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('contact') ? 'active text-warning fw-bold' : '' }}"
                           href="{{ route('contact') }}">Contact</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user.wishlist') }}">
                            Wishlist
                            @if($wishlistCount > 0)
                                <span class="badge bg-warning ms-2">{{ $wishlistCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user.cart') }}">
                            Cart
                            @if($cartCount > 0)
                                <span class="badge bg-warning ms-2">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user.edit-profile') }}">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-white border-0 bg-transparent">Logout</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">Sign Up</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // Update cart count dynamically when cart changes
    function updateCartCount(count) {
        // Update all cart icons
        document.querySelectorAll('[href*="cart"]').forEach(cartLink => {
            let badge = cartLink.querySelector('.badge-count');
            if (count > 0) {
                if (badge) {
                    badge.textContent = count;
                } else {
                    badge = document.createElement('span');
                    badge.className = 'badge-count';
                    badge.textContent = count;
                    cartLink.appendChild(badge);
                }
            } else if (badge) {
                badge.remove();
            }
        });
    }

    // Listen for cart updates from other pages
    document.addEventListener('cartUpdated', function(e) {
        if (e.detail && e.detail.count !== undefined) {
            updateCartCount(e.detail.count);
        }
    });

    // Dispatch event when cart is updated (for other pages to listen to)
    function dispatchCartUpdate(count) {
        const event = new CustomEvent('cartUpdated', { detail: { count: count } });
        document.dispatchEvent(event);
    }
</script>
@endpush