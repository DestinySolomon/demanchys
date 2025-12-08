<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $settings['site_name'] ?? 'De Manchys Lounge' }}</title>
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
    @if(!empty($settings['favicon']))
      <link rel="icon" href="{{ \Illuminate\Support\Facades\Storage::url($settings['favicon']) }}?v={{ $settings_version ?? time() }}" />
    @endif
    
    <style>
        /* User icons styles */
        .user-nav-icons {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nav-icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            color: #333;
            transition: all 0.3s;
        }
        
        .nav-icon-btn:hover {
            background-color: rgba(0,0,0,0.05);
            color: #dc3545;
        }
        
        .nav-icon-btn i {
            font-size: 1.2rem;
        }
        
        .badge-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-avatar-initials {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            border-radius: 8px;
            padding: 0.5rem 0;
            min-width: 200px;
        }
        
        .user-dropdown-item {
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }
        
        .user-dropdown-item:hover {
            background-color: #f8f9fa;
            color: #dc3545;
        }
        
        .user-dropdown-item i {
            width: 20px;
            margin-right: 10px;
        }
        
        .user-dropdown-divider {
            margin: 0.5rem 0;
            border-top: 1px solid #dee2e6;
        }
        
        .user-dropdown-toggle {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .user-dropdown-toggle:hover {
            background-color: rgba(0,0,0,0.05);
        }
        
        @media (max-width: 768px) {
            .nav-icon-btn {
                width: 36px;
                height: 36px;
            }
            
            .nav-icon-btn i {
                font-size: 1.1rem;
            }
            
            .user-dropdown-toggle span {
                display: none;
            }
        }
    </style>
</head>
<body>

  <!-- Shared Navbar Component -->
  @include('components.navbar')

  <main style="margin-top: 80px;">
      @yield('content')
  </main>

  <!-- Footer -->
  @include('components.footer')

  {{-- JQUERY --}}

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- SweetAlert2 for nice alerts -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="{{ asset('assets/script.js') }}"></script>
  
  <!-- WhatsApp Widget -->
  @include('components.whatsapp-widget')
  
  @stack('scripts')
   
  <!-- Auth Modal -->
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

@php
use App\Models\Setting;
@endphp

@if(Setting::getValue('google_analytics_enabled') && Setting::getValue('google_analytics_id'))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ Setting::getValue('google_analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ Setting::getValue('google_analytics_id') }}');
    </script>
@endif

<script>
    // Auto-show auth modal for guests (optional)
    @if(!auth()->check() && request()->has('show_auth'))
        document.addEventListener('DOMContentLoaded', function() {
            var authModal = new bootstrap.Modal(document.getElementById('authModal'));
            authModal.show();
        });
    @endif
</script>
</body>
</html>