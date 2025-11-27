<!-- Sidebar Menu -->
<ul class="list-unstyled mb-0">
    <!-- Dashboard -->
    <li class="mb-1">
        <a href="{{ route('dashboard') }}" 
     class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
        data-title="Dashboard Overview">
            <i class="bi bi-speedometer2 me-3"></i>
            <span>Dashboard Overview</span>
        </a>
    </li>

    <!-- Manage Menu -->
    <li class="mb-1">
        <a class="sidebar-menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#menuCollapse" data-title="Manage Menu">
            <i class="bi bi-menu-button me-3"></i>
            <span>Manage Menu</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <div class="collapse" id="menuCollapse">
            <ul class="list-unstyled ms-4 mt-2">
                         <li class="mb-2">
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-submenu-item">
                          <i class="bi bi-tags me-2"></i>
                          <span>Categories</span>
                        </a>
               </li>
                <li class="mb-2">
                    
                   <a href="{{ route('admin.menu-items.index') }}" class="sidebar-submenu-item">
                <i class="fa fa-cutlery"></i> <span>Menu Items</span>
            </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="sidebar-submenu-item">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span>Add-ons</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Manage Orders -->
    <li class="mb-1">
        <a class="sidebar-menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#ordersCollapse" data-title="Manage Orders">
            <i class="bi bi-cart-check me-3"></i>
            <span>Manage Orders</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <div class="collapse" id="ordersCollapse">
            <ul class="list-unstyled ms-4 mt-2">
                <li class="mb-2">
                    <a href="#" class="sidebar-submenu-item">
                        <i class="bi bi-list-ul me-2"></i>
                        <span>All Orders</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="sidebar-submenu-item">
                        <i class="bi bi-truck me-2"></i>
                        <span>Delivery Orders</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="sidebar-submenu-item">
                        <i class="bi bi-shop me-2"></i>
                        <span>Eat-in Orders</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="sidebar-submenu-item">
                        <i class="bi bi-bag me-2"></i>
                        <span>Takeaway Orders</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Coming Soon Items -->
    <li class="mb-1">
                <a class="sidebar-menu-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" data-title="Manage Events">
            <i class="bi bi-calendar-event me-3"></i>
            <span>Manage Events</span>
        </a>
    </li>
    
    <li class="mb-1">
        <a class="sidebar-menu-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}" data-title="Manage Gallery">
            <i class="bi bi-images me-3"></i>
            <span>Manage Gallery</span>
        </a>
    </li>
    
    <li class="mb-1">
        <a class="sidebar-menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-title="Manage Users">
            <i class="bi bi-people me-3"></i>
            <span>Manage Users</span>
        </a>
    </li>



    
    <!-- More items will be added as we build them -->
</ul>