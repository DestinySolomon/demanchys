<!-- Sidebar -->
<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="user-welcome">
            @auth
                @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                         alt="Profile" 
                         class="user-avatar-sidebar">
                @else
                    <div class="user-avatar-initials-sidebar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="user-info">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p>{{ auth()->user()->email }}</p>
                </div>
            @endauth
        </div>
    </div>
    
    <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
            <a href="{{ route('user.dashboard') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('user.edit-profile') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.edit-profile') ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                Edit Profile
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('user.address') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.address') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i>
                Address
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('user.orders') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                <i class="bi bi-bag"></i>
                My Orders
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('user.bookings') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.bookings') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                My Bookings
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('user.wishlist') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">
                <i class="bi bi-heart"></i>
                Wishlist
                @php
                    $wishlistCount = 0; // Update this when you create wishlist table
                @endphp
                @if($wishlistCount > 0)
                    <span class="badge bg-warning ms-auto">{{ $wishlistCount }}</span>
                @endif
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('user.reviews') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.reviews') ? 'active' : '' }}">
                <i class="bi bi-star"></i>
                My Reviews
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('user.change-password') }}" 
               class="sidebar-menu-link {{ request()->routeIs('user.change-password') ? 'active' : '' }}">
                <i class="bi bi-key"></i>
                Change Password
            </a>
        </li>
        <li class="sidebar-menu-item">
            <form method="POST" action="{{ route('logout') }}" class="sidebar-menu-link" style="cursor: pointer;">
                @csrf
                <button type="submit" class="border-0 bg-transparent p-0 d-flex align-items-center w-100 text-start" style="color: inherit;">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </li>
    </ul>
</aside>