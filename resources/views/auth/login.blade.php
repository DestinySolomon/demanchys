<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Demanchys Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .split-container {
            display: flex;
            min-height: 100vh;
        }
        .brand-side {
            flex: 1;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .form-side {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
        }
        .logo {
            font-size: 3rem;
            font-weight: bold;
            color: #ffc107;
            margin-bottom: 1rem;
        }
        .logo-image {
            max-width: 200px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(255, 193, 7, 0.3));
            margin-bottom: 2rem;
        }
        .logo-text {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ffc107;
            margin-bottom: 2rem;
            display: none;
        }
        .has-logo-image .logo-text {
            display: none;
        }
        .has-logo-image .logo-image {
            display: block;
        }
        .no-logo-image .logo-text {
            display: block;
        }
        .no-logo-image .logo-image {
            display: none;
        }
        .tagline {
            font-size: 1.2rem;
            color: #ccc;
            text-align: center;
            max-width: 400px;
        }
        
        /* Animation Elements */
        .floating-cocktail {
            position: absolute;
            font-size: 2rem;
            opacity: 0.7;
            animation: float 6s ease-in-out infinite;
        }
        .floating-music {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.5;
            animation: float 8s ease-in-out infinite;
        }
        .floating-food {
            position: absolute;
            font-size: 1.8rem;
            opacity: 0.6;
            animation: float 7s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        .btn-google {
            background: #db4437;
            color: white;
            border: none;
            padding: 0.75rem;
        }
        .btn-google:hover {
            background: #c23321;
            color: white;
        }
        
        /* Google Button Styles */
        .btn-google-custom {
            background-color: #ffffff;
            border: 1px solid #dadce0;
            color: #3c4043;
            font-weight: 500;
            transition: background-color 0.2s, box-shadow 0.2s;
        }
        .btn-google-custom:hover {
            background-color: #f8f9fa;
            box-shadow: 0 1px 3px 1px rgba(66, 64, 67, 0.15);
            color: #3c4043;
        }
        .btn-google-custom:active {
            background-color: #f1f3f4;
        }
        .btn-google-custom:focus {
            box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.3);
        }
        
        @media (max-width: 768px) {
            .split-container {
                flex-direction: column;
            }
            .brand-side {
                min-height: 40vh;
            }
            .form-side {
                min-height: 60vh;
            }
            .logo-image {
                max-width: 150px;
            }
            .logo-text {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    @php
        use App\Models\Setting;
    @endphp
    
    <div class="split-container">
        <!-- Brand Side -->
        <div class="brand-side {{ Setting::getValue('logo') ? 'has-logo-image' : 'no-logo-image' }}">
            <!-- Animated Elements -->
            <div class="floating-cocktail" style="top: 20%; left: 20%; animation-delay: 0s;">🍸</div>
            <div class="floating-music" style="top: 70%; left: 80%; animation-delay: 1s;">🎵</div>
            <div class="floating-food" style="top: 40%; left: 80%; animation-delay: 2s;">🍽️</div>
            <div class="floating-cocktail" style="top: 80%; left: 10%; animation-delay: 3s;">🥂</div>
            <div class="floating-music" style="top: 30%; left: 10%; animation-delay: 4s;">🎷</div>
            <div class="floating-food" style="top: 60%; left: 70%; animation-delay: 5s;">🍷</div>
            
            <!-- Brand Content -->
            <div class="text-center">
                <!-- Dynamic Logo -->
                @if(Setting::getValue('logo'))
                    <img src="{{ asset('storage/' . Setting::getValue('logo')) }}" 
                         alt="Demanchys Lounge" 
                         class="logo-image"
                         onerror="this.style.display='none'; document.querySelector('.brand-side').classList.remove('has-logo-image'); document.querySelector('.brand-side').classList.add('no-logo-image');">
                @endif
                
                <!-- Fallback Text Logo -->
                <div class="logo-text">Demanchys Lounge</div>
                
                <div class="tagline">
                    Welcome back to luxury. Your table is waiting.
                </div>
                <div class="mt-4 text-center">
                    <div class="text-warning mb-2">🎭 Exclusive Events Access</div>
                    <div class="text-warning mb-2">🍹 Personalized Service</div>
                    <div class="text-warning">⭐ Priority Reservations</div>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="form-side">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1">Welcome Back</h2>
                        <p class="text-muted mb-4">Sign in to your account</p>

                        <!-- Google OAuth -->
                        <div class="text-center mb-4">
                            <a href="{{ route('google.login') }}" class="btn btn-google-custom w-100 py-2">
                                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="me-2">
                                    <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                                    <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                                    <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                                    <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                                </svg>
                                Continue with Google
                            </a>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center text-muted mx-3 mb-0">Or sign in with email or phone</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Single Login Field -->
                            <div class="mb-3">
                                <label for="login" class="form-label">Email or Phone Number</label>
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" 
                                       name="login" value="{{ old('login') }}" required autofocus 
                                       placeholder="Enter your email or phone number">
                                @error('login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg py-3 fw-bold">
                                    Sign In
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <a class="text-decoration-none text-dark" href="{{ route('register') }}">
                                    Don't have an account? <span class="text-warning fw-bold">Sign up</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>