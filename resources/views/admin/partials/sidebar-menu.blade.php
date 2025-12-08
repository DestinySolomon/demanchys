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
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                          <i class="bi bi-tags me-2"></i>
                          <span>Categories</span>
                        </a>
               </li>
                <li class="mb-2">
                    
                   <a href="{{ route('admin.menu-items.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
                <i class="fa fa-cutlery"></i> <span>Menu Items</span>
            </a>
                </li>
               <li class="mb-2">
              <a href="{{ route('admin.add-ons.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.add-ons.*') ? 'active' : '' }}">
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
    <div class="collapse {{ request()->routeIs('admin.orders.*') ? 'show' : '' }}" id="ordersCollapse">
        <ul class="list-unstyled ms-4 mt-2">
            <li class="mb-2">
                <a href="{{ route('admin.orders.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul me-2"></i>
                    <span>All Orders</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.orders.delivery') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.orders.delivery') ? 'active' : '' }}">
                    <i class="bi bi-truck me-2"></i>
                    <span>Delivery Orders</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.orders.eat-in') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.orders.eat-in') ? 'active' : '' }}">
                    <i class="bi bi-shop me-2"></i>
                    <span>Eat-in Orders</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.orders.takeaway') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.orders.takeaway') ? 'active' : '' }}">
                    <i class="bi bi-bag me-2"></i>
                    <span>Takeaway Orders</span>
                </a>
            </li>
        </ul>
    </div>
</li>

    <!-- Delivery Man -->
<li class="mb-1">
    <a class="sidebar-menu-item {{ request()->routeIs('admin.delivery.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#deliveryCollapse" data-title="Delivery Man">
        <i class="bi bi-truck me-3"></i>
        <span>Delivery Man</span>
        <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse {{ request()->routeIs('admin.delivery.*') ? 'show' : '' }}" id="deliveryCollapse">
        <ul class="list-unstyled ms-4 mt-2">
            <li class="mb-2">
                <a href="{{ route('admin.delivery.pending') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.delivery.pending') ? 'active' : '' }}">
                    <i class="bi bi-clock me-2"></i>
                    <span>Pending Applications</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.delivery.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.delivery.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul me-2"></i>
                    <span>Active Delivery Men</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.delivery.rejected') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.delivery.rejected') ? 'active' : '' }}">
                    <i class="bi bi-x-circle me-2"></i>
                    <span>Rejected Applications</span>
                </a>
            </li>
        </ul>
    </div>
</li>
    
    <!-- Manage Events -->
<li class="mb-1">
    <a class="sidebar-menu-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#eventsCollapse" data-title="Manage Events">
        <i class="bi bi-calendar-event me-3"></i>
        <span>Manage Events</span>
        <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse {{ request()->routeIs('admin.events.*') ? 'show' : '' }}" id="eventsCollapse">
        <ul class="list-unstyled ms-4 mt-2">
            <li class="mb-2">
                <a href="{{ route('admin.events.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.events.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul me-2"></i>
                    <span>All Events</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.events.upcoming') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.events.upcoming') ? 'active' : '' }}">
                    <i class="bi bi-clock me-2"></i>
                    <span>Upcoming Events</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.events.ongoing') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.events.ongoing') ? 'active' : '' }}">
                    <i class="bi bi-play-circle me-2"></i>
                    <span>Ongoing Events</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.events.past') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.events.past') ? 'active' : '' }}">
                    <i class="bi bi-check-circle me-2"></i>
                    <span>Past Events</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.events.create') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.events.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle me-2"></i>
                    <span>Create Event</span>
                </a>
            </li>
        </ul>
    </div>
</li>

    <!-- Booking Management -->
<li class="mb-1">
    <a class="sidebar-menu-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#bookingsCollapse" data-title="Booking Management">
        <i class="bi bi-calendar-check me-3"></i>
        <span>Booking Management</span>
        <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse {{ request()->routeIs('admin.bookings.*') ? 'show' : '' }}" id="bookingsCollapse">
        <ul class="list-unstyled ms-4 mt-2">
            <li class="mb-2">
                <a href="{{ route('admin.bookings.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.bookings.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul me-2"></i>
                    <span>All Bookings</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.bookings.today') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.bookings.today') ? 'active' : '' }}">
                    <i class="bi bi-calendar-day me-2"></i>
                    <span>Today's Bookings</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.bookings.calendar') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.bookings.calendar') ? 'active' : '' }}">
                    <i class="bi bi-calendar-week me-2"></i>
                    <span>Booking Calendar</span>
                </a>
            </li>
        </ul>
    </div>
</li>

    <!-- Manage Banner -->
<!-- Manage Banner -->
<li class="mb-1">
    <a class="sidebar-menu-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" 
       data-bs-toggle="collapse" 
       href="#bannersCollapse" 
       data-title="Manage Banner"
       aria-expanded="{{ request()->routeIs('admin.banners.*') ? 'true' : 'false' }}"
       aria-controls="bannersCollapse">
        <i class="bi bi-image me-3"></i>
        <span>Manage Banner</span>
        <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse {{ request()->routeIs('admin.banners.*') ? 'show' : '' }}" 
         id="bannersCollapse"
         @if(request()->routeIs('admin.banners.*')) style="display: block;" @endif>
        <ul class="list-unstyled ms-4 mt-2">
            <li class="mb-2">
                <a href="{{ route('admin.banners.promotional') }}" 
                   class="sidebar-submenu-item {{ request()->routeIs('admin.banners.promotional') ? 'active' : '' }}">
                    <i class="bi bi-megaphone me-2"></i>
                    <span>Promotional Banner</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.banners.offers') }}" 
                   class="sidebar-submenu-item {{ request()->routeIs('admin.banners.offers') ? 'active' : '' }}">
                    <i class="bi bi-tag me-2"></i>
                    <span>Offer Deals</span>
                </a>
            </li>
        </ul>
    </div>
</li>
    
    <li class="mb-1">
    <a href="{{ route('admin.gallery.index') }}" 
       class="sidebar-menu-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}" 
       data-title="Manage Gallery">
        <i class="bi bi-images me-3"></i>
        <span>Manage Gallery</span>
    </a>
</li>

    <!-- Contact Messages -->
<li class="mb-1">
    <a href="{{ route('admin.contacts.index') }}" 
       class="sidebar-menu-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" 
       data-title="Contact Messages">
        <i class="bi bi-envelope me-3"></i>
        <span>Contact Messages</span>
    </a>
</li>

    <!-- Testimonials -->
<li class="mb-1">
    <a href="{{ route('admin.testimonials.index') }}" 
       class="sidebar-menu-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" 
       data-title="Testimonials">
        <i class="bi bi-chat-quote me-3"></i>
        <span>Testimonials</span>
    </a>
</li>
    
<!-- Manage Users -->
<li class="mb-1">
    <a class="sidebar-menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
       data-bs-toggle="collapse" href="#usersCollapse" data-title="Manage Users">
        <i class="bi bi-people me-3"></i>
        <span>Manage Users</span>
        <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="usersCollapse">
        <ul class="list-unstyled ms-4 mt-2">
            <li class="mb-2">
                <a href="{{ route('admin.users.index') }}" 
                   class="sidebar-submenu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul me-2"></i>
                    <span>User List</span>
                </a>
            </li>
        </ul>
    </div>
</li>

    <!-- Payment Methods - Only for Super Admin -->
    @php
        $user = Auth::user();
        $isSuperAdmin = $user->role === 'super_admin';
    @endphp
    
    @if($isSuperAdmin)
    <li class="mb-1">
        <a href="{{ route('admin.payments.index') }}" 
           class="sidebar-menu-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" 
           data-title="Payment Methods">
            <i class="bi bi-credit-card me-3"></i>
            <span>Payment Methods</span>
        </a>
    </li>
    @endif

   <!-- Settings -->
<li class="mb-1">
    <a href="{{ route('admin.settings.index') }}" 
       class="sidebar-menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
       data-title="Settings">
        <i class="bi bi-gear me-3"></i>
        <span>Settings</span>
    </a>
</li>

    <!-- Logout -->
<li class="mb-1">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-menu-item w-100 text-start border-0 bg-transparent" data-title="Logout">
            <i class="bi bi-box-arrow-right me-3"></i>
            <span>Logout</span>
        </button>
    </form>
</li>
</ul>