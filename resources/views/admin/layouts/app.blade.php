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
            --sidebar-collapsed: 80px;
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
        
        /* Sidebar Menu Styles */
        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #cbd5e0;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 0.5rem 0.25rem 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu-item.active {
            background: var(--primary-color);
            color: #000;
            font-weight: 600;
        }

        .sidebar-menu-item i:first-child {
            width: 20px;
            text-align: center;
        }

        .sidebar-submenu-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: #a0aec0;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .sidebar-submenu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transform: translateX(3px);
        }

        .sidebar-submenu-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* Collapse arrow rotation */
        .sidebar-menu-item[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        .bi-chevron-down {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        /* Collapsed sidebar styles */
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .sidebar-menu-item span,
        .sidebar.collapsed .sidebar-submenu-item span {
            opacity: 0;
            width: 0;
            display: none;
        }

        .sidebar.collapsed .sidebar-menu-item {
            justify-content: center;
            padding: 0.75rem;
            margin: 0 0.5rem 0.25rem 0.5rem;
        }

        .sidebar.collapsed .sidebar-menu-item i:first-child {
            margin-right: 0;
        }

        .sidebar.collapsed .bi-chevron-down {
            display: none;
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
            @include('admin.partials.sidebar-menu')
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
                    <h4 class="mb-0">Welcome back, Admin! 👋</h4>
                </div>
                
                <div class="topbar-right">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-house"></i> Home
                    </a>
                    <div class="dropdown">
                        <img src="{{ asset('assets/images/admin/profile.jpg') }}" 
                             class="rounded-circle" 
                             width="35" 
                             height="35"
                             style="object-fit: cover;"
                             data-bs-toggle="dropdown"
                             alt="Admin Profile">
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