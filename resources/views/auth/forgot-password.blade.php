<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Demanchys Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 500px;
            margin: 0 auto;
        }
        .auth-header {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            border-radius: 15px 15px 0 0;
            padding: 2rem;
            text-align: center;
        }
        .logo-image {
            max-width: 120px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(255, 193, 7, 0.3));
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="auth-card">
                    <!-- Header -->
                    <div class="auth-header">
                        <img src="{{ asset('assets/images/logo.png') }}" 
                             alt="Demanchys Lounge" 
                             class="logo-image mb-2">
                        <h4 class="text-dark fw-bold mb-0">Reset Your Password</h4>
                    </div>

                    <div class="card-body p-4">
                        <p class="text-muted mb-4">
                            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
                        </p>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="bi bi-envelope me-2"></i>Email Password Reset Link
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <a class="text-decoration-none text-dark" href="{{ route('login') }}">
                                    <i class="bi bi-arrow-left me-1"></i>Back to Login
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