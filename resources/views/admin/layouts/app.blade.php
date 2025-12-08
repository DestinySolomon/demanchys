<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Demanchys Lounge</title>
    
    <!-- Favicon -->
    @php
        use App\Models\Setting;
        $user = Auth::user();
    @endphp
    @if(Setting::getValue('favicon'))
        <link rel="shortcut icon" href="{{ asset('storage/' . Setting::getValue('favicon')) }}" type="image/x-icon">
    @else
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed: 80px;
            --topbar-height: 60px;
            --primary-color: #ffc107; /* Gold */
            --sidebar-bg: #ffffff; /* White */
            --sidebar-text: #2d3748; /* Dark gray/black */
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
            background: var(--sidebar-bg); /* Changed to white */
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-x: hidden;
            border-right: 1px solid #e2e8f0; /* Light border */
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        
        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0; /* Light border */
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
            overflow: hidden;
        }
        
        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        
        .logo-text {
            font-weight: bold;
            color: #000;
        }
        
        .brand-text {
            color: var(--sidebar-text); /* Black text */
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

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text); /* Black text */
            text-decoration: none;
            border-radius: 6px;
            margin: 0 0.5rem 0.25rem 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu-item:hover {
            background: #fff9e6; /* Light gold background */
            color: var(--sidebar-text);
            transform: translateX(5px);
        }

        .sidebar-menu-item.active {
            background: var(--primary-color); /* Gold */
            color: #000;
            font-weight: 600;
        }

        .sidebar-menu-item i:first-child {
            width: 20px;
            text-align: center;
            color: var(--primary-color); /* Gold icons */
        }

        .sidebar-submenu-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: var(--sidebar-text); /* Black text */
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            border-left: 2px solid transparent;
        }

        .sidebar-submenu-item:hover {
            background: #fff9e6; /* Light gold background */
            color: var(--sidebar-text);
            transform: translateX(3px);
            border-left: 2px solid var(--primary-color); /* Gold border */
        }

        .sidebar-submenu-item.active {
            background: var(--primary-color); /* Gold */
            color: #000;
            font-weight: 600;
            border-left: 2px solid var(--primary-color);
        }

        .sidebar-submenu-item i {
            color: var(--primary-color); /* Gold icons */
            font-size: 0.8rem;
        }

        /* Notification Styles */
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-item.unread {
            background-color: #f0f7ff;
            border-left: 3px solid #007bff;
        }

        .notification-item.read {
            opacity: 0.7;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .notification-icon.order {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .notification-icon.booking {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .notification-icon.system {
            background-color: #fff3e0;
            color: #f57c00;
        }

        .notification-icon.user {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .notification-icon.contact {
            background-color: #e0f2f1;
            color: #00796b;
        }

        .notification-time {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .notification-badge {
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
        }

        /* Floating Home Button */
        .floating-home-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .floating-home-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            color: #000;
        }

        .floating-home-btn i {
            font-size: 1.5rem;
        }

        /* Notification dropdown */
        .notification-dropdown {
            min-width: 350px;
            max-width: 400px;
        }

        @media (max-width: 576px) {
            .notification-dropdown {
                min-width: 300px;
                max-width: 90vw;
                transform: translateX(-50%);
                left: 50% !important;
                right: auto !important;
            }
        }

        /* Pulse animation for new notifications */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .badge-pulse {
            animation: pulse 0.5s ease-in-out;
        }
        
        /* Dropdown cursor pointer */
        .dropdown-toggle-custom {
            cursor: pointer;
        }
        
        /* Logout button fix */
        .dropdown-item button {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 0;
        }
        
        /* Welcome message styling */
        .welcome-message {
            font-weight: 600;
            color: #2d3748;
        }
        
        /* Logo image styles */
        .logo.has-image {
            background: transparent;
        }
        
        .logo.has-image .logo-img {
            display: block;
        }
        
        .logo.has-image .logo-text {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo {{ Setting::getValue('logo') ? 'has-image' : '' }}">
                    @if(Setting::getValue('logo'))
                        <img src="{{ asset('storage/' . Setting::getValue('logo')) }}" 
                             alt="Demanchys Lounge Logo" 
                             class="logo-img"
                             onerror="this.style.display='none'; this.parentElement.classList.remove('has-image');">
                        <span class="logo-text">DL</span>
                    @else
                        <span class="logo-text">DL</span>
                    @endif
                </div>
                <span class="brand-text text-dark">Demanchys Lounge</span>
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
                    <h4 class="mb-0 welcome-message">Welcome back, {{ $user->name }}! 👋</h4>
                </div>
                
                <div class="topbar-right">
                    <!-- Notification Bell -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm position-relative dropdown-toggle-custom" 
                                id="notificationDropdown" 
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                  id="notificationBadge" 
                                  style="display: none;">
                                0
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown" 
                            aria-labelledby="notificationDropdown">
                            <li class="dropdown-header bg-light border-bottom py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><strong>Notifications</strong></h6>
                                    <small>
                                        <a href="#" class="text-decoration-none mark-all-read" id="markAllRead">
                                            Mark all as read
                                        </a>
                                    </small>
                                </div>
                            </li>
                            <li>
                                <div id="notificationsList" class="p-3 text-center">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted mt-2 mb-0">Loading notifications...</p>
                                </div>
                            </li>
                            <li class="dropdown-footer bg-light border-top py-2 text-center">
                                <a href="{{ route('admin.notifications.index') }}" class="text-decoration-none">
                                    View all notifications
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- User Profile Dropdown - FIXED -->
                    <div class="dropdown">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}?t={{ time() }}" 
                                 class="rounded-circle dropdown-toggle-custom" 
                                 width="35" 
                                 height="35"
                                 style="object-fit: cover; cursor: pointer;"
                                 data-bs-toggle="dropdown"
                                 alt="{{ $user->name }}"
                                 title="{{ $user->name }}">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white dropdown-toggle-custom"
                                 style="width: 35px; height: 35px; font-size: 14px; cursor: pointer;"
                                 data-bs-toggle="dropdown"
                                 title="{{ $user->name }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" style="cursor: pointer;">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
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

    <!-- Floating Home Button -->
    <a href="{{ route('home') }}" class="floating-home-btn" title="Go to Home Page">
        <i class="bi bi-house"></i>
    </a>

    <!-- Bootstrap & jQuery -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
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

        // Notification System - PRODUCTION READY
        class NotificationSystem {
            constructor() {
                this.pollingInterval = null;
                this.pollingDelay = 30000; // 30 seconds
                this.unreadCount = 0;
                this.init();
            }

            init() {
                // Load initial notifications
                this.loadNotifications();
                
                // Start polling for new notifications
                this.startPolling();
                
                // Setup event listeners
                this.setupEventListeners();
            }

            setupEventListeners() {
                // Mark all as read
                $('#markAllRead').on('click', (e) => {
                    e.preventDefault();
                    this.markAllAsRead();
                });

                // Notification dropdown show event
                $('#notificationDropdown').on('show.bs.dropdown', () => {
                    this.loadNotifications();
                });
            }

            async loadNotifications() {
                try {
                    const response = await $.ajax({
                        url: '/admin/notifications/list',
                        method: 'GET',
                        dataType: 'json'
                    });

                    if (response && Array.isArray(response.notifications)) {
                        this.renderNotifications(response.notifications);
                        this.updateBadge(response.unread_count || 0);
                    } else {
                        throw new Error('Invalid response format');
                    }
                } catch (error) {
                    console.error('Error loading notifications:', error);
                    this.showError('Failed to load notifications');
                }
            }

            renderNotifications(notifications) {
                if (!notifications || notifications.length === 0) {
                    $('#notificationsList').html(`
                        <div class="text-center py-4">
                            <i class="bi bi-bell-slash text-muted fs-4"></i>
                            <p class="text-muted mt-2">No notifications yet</p>
                        </div>
                    `);
                    return;
                }

                let html = '<div class="list-group list-group-flush">';
                
                notifications.forEach((notification) => {
                    // Extract data from notification
                    let title = notification.title || 'Notification';
                    let message = notification.message || 'No details available';
                    let type = notification.type || 'system';
                    let createdAt = notification.created_at || new Date().toISOString();
                    let readAt = notification.read_at;
                    let notificationId = notification.id;
                    let timeAgo = notification.time_ago || this.getTimeAgo(createdAt);
                    
                    const iconClass = this.getIconClass(type);
                    const readClass = readAt ? 'read' : 'unread';
                    
                    html += `
                        <div class="list-group-item notification-item ${readClass}" 
                             data-id="${notificationId}" 
                             data-read="${readAt ? 'true' : 'false'}">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon ${iconClass}">
                                    <i class="bi ${this.getIcon(type)}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-1">${this.escapeHtml(title)}</h6>
                                        <small class="notification-time">${timeAgo}</small>
                                    </div>
                                    <p class="mb-1 small">${this.escapeHtml(message)}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += '</div>';
                $('#notificationsList').html(html);

                // Add click event to mark as read
                $('#notificationsList').find('.notification-item.unread').on('click', (e) => {
                    const notificationId = $(e.currentTarget).data('id');
                    this.markAsRead(notificationId, e.currentTarget);
                });
            }

            escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            getIconClass(type) {
                const iconMap = {
                    'order': 'order',
                    'booking': 'booking',
                    'system': 'system',
                    'user': 'user',
                    'contact': 'contact'
                };
                return iconMap[type] || iconMap[type?.toLowerCase()] || 'system';
            }

            getIcon(type) {
                const iconMap = {
                    'order': 'bi-cart',
                    'booking': 'bi-calendar-check',
                    'system': 'bi-exclamation-triangle',
                    'user': 'bi-person-plus',
                    'contact': 'bi-envelope'
                };
                return iconMap[type] || iconMap[type?.toLowerCase()] || 'bi-bell';
            }

            getTimeAgo(dateString) {
                try {
                    const date = new Date(dateString);
                    if (isNaN(date.getTime())) {
                        return 'recently';
                    }
                    
                    const now = new Date();
                    const seconds = Math.floor((now - date) / 1000);
                    
                    if (seconds < 60) return 'just now';
                    if (seconds < 3600) return Math.floor(seconds / 60) + 'm ago';
                    if (seconds < 86400) return Math.floor(seconds / 3600) + 'h ago';
                    return Math.floor(seconds / 86400) + 'd ago';
                } catch (error) {
                    return 'recently';
                }
            }

            updateBadge(count) {
                this.unreadCount = count;
                
                // Update desktop badge
                const $badge = $('#notificationBadge');
                
                if (count > 0) {
                    $badge.text(count > 99 ? '99+' : count).show();
                    
                    // Add pulse animation for new notifications
                    if (count > this.unreadCount) {
                        $badge.addClass('badge-pulse');
                        setTimeout(() => {
                            $badge.removeClass('badge-pulse');
                        }, 500);
                    }
                } else {
                    $badge.hide();
                }
            }

            async markAsRead(notificationId, element) {
                try {
                    await $.ajax({
                        url: `/admin/notifications/${notificationId}/read`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        }
                    });

                    $(element).removeClass('unread').addClass('read');
                    $(element).attr('data-read', 'true');
                    
                    // Update badge count
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                    this.updateBadge(this.unreadCount);
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                    // Still update UI even if server fails
                    $(element).removeClass('unread').addClass('read');
                    $(element).attr('data-read', 'true');
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                    this.updateBadge(this.unreadCount);
                }
            }

            async markAllAsRead() {
                try {
                    await $.ajax({
                        url: '/admin/notifications/mark-all-read',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        }
                    });

                    // Update all notifications to read
                    $('.notification-item').removeClass('unread').addClass('read');
                    $('.notification-item').attr('data-read', 'true');
                    
                    // Update badge
                    this.unreadCount = 0;
                    this.updateBadge(0);
                    
                    // Show success message
                    this.showToast('All notifications marked as read', 'success');
                } catch (error) {
                    console.error('Error marking all as read:', error);
                    this.showToast('Failed to mark all as read', 'error');
                }
            }

            showError(message) {
                $('#notificationsList').html(`
                    <div class="text-center py-3">
                        <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                        <p class="text-muted mt-2">${message}</p>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="window.notificationSystem.loadNotifications()">
                            <i class="bi bi-arrow-clockwise"></i> Retry
                        </button>
                    </div>
                `);
            }

            showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
                toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1050;';
                toast.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(toast);
                
                // Auto remove after 3 seconds
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 3000);
            }

            startPolling() {
                // Check for new notifications every 30 seconds
                this.pollingInterval = setInterval(() => {
                    this.checkNewNotifications();
                }, this.pollingDelay);
            }

            async checkNewNotifications() {
                try {
                    const response = await $.ajax({
                        url: '/admin/notifications/unread-count',
                        method: 'GET',
                        dataType: 'json'
                    });

                    if (response && response.count > this.unreadCount) {
                        // New notifications detected
                        this.updateBadge(response.count);
                        
                        // Update notifications if dropdown is open
                        if ($('#notificationDropdown').hasClass('show')) {
                            this.loadNotifications();
                        }
                    }
                } catch (error) {
                    console.error('Error checking new notifications:', error);
                }
            }

            stopPolling() {
                if (this.pollingInterval) {
                    clearInterval(this.pollingInterval);
                }
            }
        }

        // Initialize notification system when page loads
        document.addEventListener('DOMContentLoaded', function() {
            window.notificationSystem = new NotificationSystem();
        });
    </script>

    @stack('scripts')

    @if(request()->routeIs('admin.banners.*'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Force the banners collapse to stay open on banner pages
            const bannersCollapse = document.getElementById('bannersCollapse');
            const bannersToggle = document.querySelector('a[href="#bannersCollapse"]');
            
            if (bannersCollapse) {
                bannersCollapse.classList.add('show');
            }
            if (bannersToggle) {
                bannersToggle.setAttribute('aria-expanded', 'true');
                bannersToggle.classList.remove('collapsed');
            }
        });
    </script>
    @endif
</body>
</html>