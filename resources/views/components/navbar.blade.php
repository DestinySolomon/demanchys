<nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">
      <!-- logo in public/assets/logo.png -->
      <img src="{{ asset('assets/logo.png') }}" alt="De Manchys Lounge Logo" height="50">
    </a>

    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">Events</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
      </ul>
    </div>

    <!-- small user icon button (opens auth modal we can add later) -->
    <button class="btn btn-warning d-flex align-items-center" style="height:42px; width:42px;"
            data-bs-toggle="modal" data-bs-target="#authModal">
      <i class="bi bi-person"></i>
    </button>
  </div>
</nav>
