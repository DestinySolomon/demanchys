<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Demanchys Lounge</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed: 70px;
            --topbar-height: 60px;
            --primary-color: #ffc107;
            --dark-bg: #1a1d29;
            --darker-bg: #151824;
        }
        
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--dark-bg);
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-x: hidden;
            border-right: 1px solid #2d3748;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        
        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid #2d3748;
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        
        .logo {
            width: 32px;
            height: 32px;
            background: var(--primary-color);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #000;
            flex-shrink: 0;
        }
        
        .brand-text {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.3s ease;
        }
        
        .sidebar.collapsed .brand-text {
            opacity: 0;
            width: 0;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
            height: calc(100vh - var(--topbar-height));
            overflow-y: auto;
        }
        
        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            background: #f8f9fa;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }
        
        /* Topbar Styles */
        .topbar {
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .topbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding: 0 1rem;
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        /* Toggle button - Arrow style */
        .sidebar-toggle {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-toggle:hover {
            background: #e9ecef;
            color: #495057;
        }
        
        /* Content Area */
        .content-wrapper {
            padding: 1.5rem;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .sidebar.collapsed {
                transform: translateX(-100%);
                width: 250px;
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .main-content.expanded {
                margin-left: 0 !important;
            }
            
            .topbar-content {
                padding: 0 0.5rem;
            }
            
            .topbar-left h4 {
                font-size: 1.1rem;
            }
            
            .topbar-right {
                gap: 0.5rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }
            
            .dropdown img {
                width: 30px;
                height: 30px;
            }
        }
        
        @media (max-width: 576px) {
            .topbar-left h4 {
                font-size: 1rem;
            }
            
            .topbar-left h4 .d-none-mobile {
                display: none;
            }
            
            .btn-sm {
                font-size: 0.8rem;
                padding: 0.2rem 0.4rem;
            }
        }
        
        @media (max-width: 400px) {
            .topbar-left h4 {
                font-size: 0.9rem;
            }
            
            .topbar-right .btn-sm .bi-house {
                margin-right: 0;
            }
            
            .topbar-right .btn-sm span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo">DL</div>
                <span class="brand-text">Demanchys Lounge</span>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <!-- Sidebar menu content will go here in next step -->
            <div class="text-center text-muted mt-5">
                <i class="bi bi-layout-sidebar text-white-50"></i>
                <div class="sidebar.collapsed:hidden text-white">
                    <br><small>Menu coming next step</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
        <nav class="topbar">
            <div class="topbar-content">
                <div class="topbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <h4 class="mb-0">Welcome back, <span class="d-none-mobile">Admin!</span> 👋</h4>
                </div>
                
                <div class="topbar-right">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-house"></i> <span>Home</span>
                    </a>
                    <div class="dropdown">
                        <img src="{{ asset('assets/emem.jpg') }}" 
                             class="rounded-circle profile-image" width="35" height="35"
                             data-bs-toggle="dropdown">
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const icon = this.querySelector('i');
            
            if (window.innerWidth > 768) {
                // Desktop: collapse/expand sidebar
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Change arrow direction
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'bi bi-chevron-right';
                } else {
                    icon.className = 'bi bi-chevron-left';
                }
            } else {
                // Mobile: show/hide sidebar
                sidebar.classList.toggle('mobile-open');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
</body>
</html>