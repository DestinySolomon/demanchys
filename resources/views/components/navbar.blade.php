<style>
    /* Slide-in menu styles (MOBILE ONLY) */
    #mobileSlideMenu {
        position: fixed;
        top: 0;
        left: -260px;
        width: 260px;
        height: 100vh;
        background: #111;
        padding: 20px;
        transition: left 0.3s ease-in-out;
        /* Keep this below Bootstrap modal (1050) so modals appear above the menu */
        z-index: 1035;
    }

    #mobileSlideMenu.show {
        left: 0;
    }

    /* Background overlay */
    #menuOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0,0,0,0.5);
        display: none;
        /* Keep this below Bootstrap modal backdrop (1040) and modal (1050) */
        z-index: 1030;
    }

    #menuOverlay.active {
        display: block;
    }
</style>

<!-- TOP NAVBAR (LOGO + USER ICON) -->
<nav class="navbar fixed-top bg-dark py-2">
    <div class="container-fluid d-flex align-items-center">

        <!-- LOGO LEFT -->
        <a class="navbar-brand d-flex align-items-center me-3" href="{{ url('/') }}">
            @php
                $logoUrl = null;
                if (!empty($settings['logo'])) {
                    $logoUrl = \Illuminate\Support\Facades\Storage::url($settings['logo']);
                }
            @endphp
            <img src="{{ $logoUrl ?? asset('assets/logo.png') }}" alt="{{ $settings['site_name'] ?? 'De Manchys Lounge' }}" height="50">
        </a>

        <!-- CENTER MENU (desktop only) -->
        <div class="d-none d-lg-flex justify-content-center flex-grow-1">
            <ul class="navbar-nav d-flex flex-row gap-3">
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

        <!-- USER ICON RIGHT -->
        <button class="btn btn-warning rounded-circle d-flex justify-content-center align-items-center ms-3"
            style="width: 45px; height: 45px;"
            data-bs-toggle="modal"
            data-bs-target="#authModal">
            <i class="bi bi-person fs-4"></i>
        </button>

    </div>
</nav>

<!-- MOBILE HAMBURGER (ONLY on small screens) -->
<div class="d-lg-none mt-2 pt-1 px-3">
    <button id="hamburgerBtn"
        class="btn btn-outline-light w-10 d-flex justify-content-between align-items-center">
        <i class="bi bi-list fs-3"></i>
    </button>
</div>

<!-- MOBILE SLIDE-IN MENU -->
<div id="mobileSlideMenu">
    <h5 class="text-white mb-4">Menu</h5>

    <ul class="navbar-nav">
        <li class="nav-item my-2">
            <a class="nav-link text-white {{ request()->routeIs('home') ? 'text-warning fw-bold' : '' }}"
               href="{{ route('home') }}">Home</a>
        </li>

        <li class="nav-item my-2">
            <a class="nav-link text-white {{ request()->routeIs('about') ? 'text-warning fw-bold' : '' }}"
               href="{{ route('about') }}">About</a>
        </li>

        <li class="nav-item my-2">
            <a class="nav-link text-white {{ request()->routeIs('menu') ? 'text-warning fw-bold' : '' }}"
               href="{{ route('menu') }}">Menu</a>
        </li>

        <li class="nav-item my-2">
            <a class="nav-link text-white {{ request()->routeIs('events.*') ? 'text-warning fw-bold' : '' }}"
               href="{{ route('events.index') }}">Events</a>
        </li>

        <li class="nav-item my-2">
            <a class="nav-link text-white {{ request()->routeIs('contact') ? 'text-warning fw-bold' : '' }}"
               href="{{ route('contact') }}">Contact</a>
        </li>
    </ul>
</div>

<!-- OVERLAY -->
<div id="menuOverlay"></div>

<!-- (desktop menu integrated into fixed-top navbar above) -->

<script>
    const btn = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileSlideMenu');
    const overlay = document.getElementById('menuOverlay');

    btn.addEventListener('click', () => {
        menu.classList.toggle('show');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
        menu.classList.remove('show');
        overlay.classList.remove('active');
    });

    document.querySelectorAll('#mobileSlideMenu a').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.remove('show');
            overlay.classList.remove('active');
        });
    });

    // Close mobile slide menu automatically when any Bootstrap modal opens
    document.addEventListener('show.bs.modal', function () {
        try {
            // hide menu
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
            }

            // remove active overlay class
            if (overlay.classList.contains('active')) {
                overlay.classList.remove('active');
            }

            // force-hide overlay and disable pointer events so modal is interactive
            overlay.style.display = 'none';
            overlay.style.pointerEvents = 'none';
            overlay.style.zIndex = '0';
        } catch (err) {
            // If elements are missing, ignore — defensive fallback
            console.warn('Menu auto-close: element missing', err);
        }
    });
</script>
