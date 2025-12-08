<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Account - Demanchys Lounge')</title>
    
    <!-- Your existing styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&family=Rouge+Script&family=Tangerine:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Pacifico&display=swap" rel="stylesheet">
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    
    <style>
        /* RESET - Force white background */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
        }
        
        body {
            background: #ffffff !important;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Navbar Styles */
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
        
        /* User Icons Styles */
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
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            transition: all 0.3s;
        }
        
        .nav-icon-btn:hover {
            background: rgba(255,255,255,0.1);
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
        
        /* Mobile Icons */
        .mobile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            transition: all 0.3s;
        }

        .mobile-icon:hover {
            background: rgba(255,255,255,0.1);
            color: #ffc107;
            border-color: #ffc107;
        }

        .mobile-hamburger {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .mobile-hamburger:hover {
            background: rgba(255,255,255,0.1);
            color: #ffc107;
            border-color: #ffc107;
        }
        
        /* User Dropdown - Desktop only */
        .user-dropdown-toggle {
            background: none;
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s;
            color: white;
        }
        
        .user-dropdown-toggle:hover {
            background: rgba(255,255,255,0.1);
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
        
        /* Dashboard Container */
        .dashboard-wrapper {
            display: flex;
            flex: 1;
            margin-top: 80px; /* Space for fixed navbar */
        }
        
        /* Sidebar - ALWAYS VISIBLE ON MOBILE & DESKTOP */
        .dashboard-sidebar {
            width: 280px;
            background: #ffffff;
            border-right: 1px solid #eaeaea;
            position: fixed;
            left: 0;
            top: 80px;
            bottom: 0;
            overflow-y: auto;
            z-index: 1020;
        }
        
        /* Main Content - PURE WHITE */
        .dashboard-main {
            flex: 1;
            margin-left: 280px;
            background: #ffffff;
            min-height: calc(100vh - 80px);
            padding: 2rem;
        }
        
        /* Sidebar Styles */
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eaeaea;
            margin-bottom: 1rem;
        }
        
        .user-welcome {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar-sidebar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffc107;
        }
        
        .user-avatar-initials-sidebar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            border: 2px solid #ffc107;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu-item {
            margin: 0.25rem 0;
        }
        
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: #2d3748;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu-link:hover {
            background: #f8f9fa;
            color: #2d3748;
            border-left-color: #ffc107;
        }
        
        .sidebar-menu-link.active {
            background: rgba(255, 193, 7, 0.1);
            color: #2d3748;
            border-left-color: #ffc107;
            font-weight: 600;
        }
        
        .sidebar-menu-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        /* Card Styles */
        .dashboard-card {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        /* Footer fix - Full width */
        .dashboard-footer-wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            background: #1a1a1a;
        }
        
        /* Mobile Responsive - SIDEBAR ALWAYS VISIBLE */
        @media (max-width: 768px) {
            .dashboard-wrapper {
                flex-direction: column;
                margin-top: 80px;
            }
            
            .dashboard-sidebar {
                width: 100%;
                position: static;
                border-right: none;
                border-bottom: 1px solid #eaeaea;
                height: auto;
                margin-bottom: 0;
                padding: 1rem 0;
            }
            
            .dashboard-main {
                margin-left: 0;
                padding: 1.5rem;
                min-height: auto;
            }
            
            /* Hide desktop user dropdown on mobile */
            .user-dropdown-toggle {
                display: none !important;
            }
            
            /* Hide desktop user nav icons */
            .user-nav-icons.d-lg-flex {
                display: none !important;
            }
            
            /* Ensure mobile icons are visible */
            .d-flex.d-lg-none {
                display: flex !important;
            }
            
            /* Mobile sidebar layout */
            .sidebar-header {
                padding: 1rem;
                text-align: center;
            }
            
            .user-welcome {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem;
                padding: 0 1rem;
            }
            
            .sidebar-menu-item {
                flex: 1;
                min-width: 140px;
            }
            
            .sidebar-menu-link {
                justify-content: center;
                border-left: none;
                border-radius: 8px;
                text-align: center;
                padding: 0.75rem 1rem;
                margin: 0.125rem;
            }
            
            /* Footer full width on mobile */
            .dashboard-footer-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
        
        /* Desktop adjustments */
        @media (min-width: 769px) {
            .mobile-hamburger {
                display: none !important;
            }
            
            .d-flex.d-lg-none {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-white">

<!-- Shared Navbar Component -->
@include('components.navbar')

<!-- Dashboard Wrapper -->
<div class="dashboard-wrapper">
    <!-- Sidebar - ALWAYS VISIBLE (Mobile & Desktop) -->
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
                    <div>
                        <h6 class="mb-0 fw-bold">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                @endauth
            </div>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="{{ route('user.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('user.edit-profile') }}" class="sidebar-menu-link {{ request()->routeIs('user.edit-profile') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> Edit Profile
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('user.address') }}" class="sidebar-menu-link {{ request()->routeIs('user.address') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt"></i> Address
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('user.orders') }}" class="sidebar-menu-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                    <i class="bi bi-bag"></i> My Orders
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('user.bookings') }}" class="sidebar-menu-link {{ request()->routeIs('user.bookings') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> My Bookings
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('user.wishlist') }}" class="sidebar-menu-link {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">
                    <i class="bi bi-heart"></i> Wishlist
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('user.reviews') }}" class="sidebar-menu-link {{ request()->routeIs('user.reviews') ? 'active' : '' }}">
                    <i class="bi bi-star"></i> My Reviews
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('user.change-password') }}" class="sidebar-menu-link {{ request()->routeIs('user.change-password') ? 'active' : '' }}">
                    <i class="bi bi-key"></i> Change Password
                </a>
            </li>
            <li class="sidebar-menu-item">
                <form method="POST" action="{{ route('logout') }}" class="sidebar-menu-link">
                    @csrf
                    <button type="submit" class="border-0 bg-transparent p-0 d-flex align-items-center w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>
    
    <!-- Main Content - PURE WHITE -->
    <main class="dashboard-main bg-white">
        @yield('content')
    </main>
</div>

<!-- Footer - Full Width -->
<div class="dashboard-footer-wrapper">
    @include('components.footer')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Active sidebar link
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.sidebar-menu-link');
        
        sidebarLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    });
</script>

<!-- jQuery (needed by some page scripts) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 for alerts used in dashboard pages -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom JS -->
<script src="{{ asset('assets/script.js') }}"></script>

@stack('scripts')
</body>
</html>