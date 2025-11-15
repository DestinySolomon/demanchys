<!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top ">
      <div class="container-fluid">
        <!-- ✅ Image logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('assets/logo.png') }}" alt="De Manchys Lounge Logo" height="50">
        </a>

        <button
          class="navbar-toggler bg-light"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          title="Toggle navigation menu"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

             <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ url('home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">Events</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
      </ul>
     </div>

           <!-- 🔵 REPLACED BOOK TABLE WITH USER ICON -->
                    <button class="btn btn-warning rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 45px; height: 45px;"
                        data-bs-toggle="modal"
                        data-bs-target="#authModal">
                        <i class="bi bi-person fs-4"></i>
                    </button>
      </div>
    </nav>
