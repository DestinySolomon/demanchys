<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>De Manchys Lounge</title>
  <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&family=Rouge+Script&family=Tangerine:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Pacifico&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
</head>
<body>

  <!-- Navbar -->
  @include('components.navbar')

  <main style="margin-top: 80px;">
      @yield('content')
  </main>

  <!-- Footer -->
  @include('components.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="{{ asset('assets/script.js') }}"></script>
   <!-- put this at end of layout (before closing body) -->
<div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title">Welcome to De Manchys Lounge</h5>
        <button class=" btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-white-50">Login or create an account to enjoy a personalized experience.</p>
        <a href="{{ url('/login') }}" class="btn btn-warning w-100 mb-2">Login</a>
        <a href="{{ url('/register') }}" class="btn btn-outline-warning w-100">Create Account</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
