<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Demanchys Lounge</title>
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

        .logo-image {
    filter: drop-shadow(0 4px 8px rgba(255, 193, 7, 0.3));
    transition: transform 0.3s ease;
}
.logo-image:hover {
    transform: scale(1.05);
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
        }
    </style>
</head>
<body>
    <div class="split-container">
        <!-- Brand Side -->
        <!-- Brand Side -->
<div class="brand-side">
    <!-- Animated Elements -->
    <div class="floating-cocktail" style="top: 20%; left: 20%; animation-delay: 0s;">🍸</div>
    <div class="floating-music" style="top: 70%; left: 80%; animation-delay: 1s;">🎵</div>
    <div class="floating-food" style="top: 40%; left: 80%; animation-delay: 2s;">🍽️</div>
    <div class="floating-cocktail" style="top: 80%; left: 10%; animation-delay: 3s;">🥂</div>
    <div class="floating-music" style="top: 30%; left: 10%; animation-delay: 4s;">🎷</div>
    <div class="floating-food" style="top: 60%; left: 70%; animation-delay: 5s;">🍷</div>
    
    <!-- Brand Content with Logo Image -->
    <div class="text-center">
        <img src="{{ asset('assets/images/logo.png') }}" 
             alt="Demanchys Lounge" 
             class="logo-image mb-4"
             style="max-width: 200px; height: auto;">
        <div class="tagline">
            Where every moment becomes a memory. Join our exclusive community and experience luxury dining like never before.
        </div>
        <div class="mt-4 text-center">
            <div class="text-warning mb-2">🎉 Premium Dining Experience</div>
            <div class="text-warning mb-2">🎵 Live Music Events</div>
            <div class="text-warning">🌟 Exclusive Member Benefits</div>
        </div>
    </div>
</div>

        <!-- Form Side -->
        <div class="form-side">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1">Create Account</h2>
                        <p class="text-muted mb-4">Join our exclusive community</p>

                        <!-- Google OAuth -->
                        <div class="text-center mb-4">
                            <a href="{{ route('google.login') }}" class="btn btn-google w-100 py-2">
                                <i class="bi bi-google me-2"></i>Continue with Google
                            </a>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center text-muted mx-3 mb-0">Or register with email</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number (Optional)</label>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input id="password_confirmation" type="password" class="form-control" 
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg py-3 fw-bold">
                                    Create Account
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <a class="text-decoration-none text-dark" href="{{ route('login') }}">
                                    Already have an account? <span class="text-warning fw-bold">Sign in</span>
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