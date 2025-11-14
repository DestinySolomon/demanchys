<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>De Manchys Lounge</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <!-- Header -->
    <header class="container-fluid header-bg">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/images/logo.png') }}" class="nav-brand" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>

                    <!-- 🔵 REPLACED BOOK TABLE WITH USER ICON -->
                    <button class="btn btn-warning rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 45px; height: 45px;"
                        data-bs-toggle="modal"
                        data-bs-target="#authModal">
                        <i class="bi bi-person fs-4"></i>
                    </button>

                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <h1 class="hero-title">WE SERVE THE BEST AFRICAN DISHES</h1>
                    <p class="hero-subtitle">Your favorite spot for delicious meals and relaxation.</p>
                    <a href="#menu" class="btn btn-warning btn-lg">Explore Menu</a>
                </div>
                <div class="col-lg-6 col-md-6 text-center">
                    <img src="{{ asset('assets/images/hero.png') }}" class="hero-img" alt="">
                </div>
            </div>
        </section>
    </header>


    <!-- About Section -->
    <section id="about" class="container about-section">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/about.jpg') }}" class="img-fluid about-img" alt="">
            </div>
            <div class="col-md-6">
                <h2>About De Manchys Lounge</h2>
                <p>We bring you the best of African cuisine with a touch of luxury and comfort...</p>
            </div>
        </div>
    </section>


    <!-- Menu Section -->
    <section id="menu" class="container menu-section">
        <h2 class="text-center mb-4">Our Menu</h2>
        <div class="row">

            @foreach(range(1,6) as $i)
            <div class="col-md-4 mb-4">
                <div class="menu-card">
                    <img src="{{ asset('assets/images/menu'.$i.'.jpg') }}" alt="">
                    <div class="menu-card-body">
                        <h5>Dish Name {{ $i }}</h5>
                        <p>Delicious taste from the best African cuisine.</p>
                        <span class="price">₦2,500</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </section>


    <!-- Events Section -->
    <section id="events" class="events-section">
        <div class="container">
            <h2 class="text-center mb-4">Upcoming Events</h2>

            <div class="row">
                <div class="col-md-6">
                    <div class="event-card">
                        <img src="{{ asset('assets/images/event1.jpg') }}" alt="">
                        <div class="event-info">
                            <h4>Friday Night Live Band</h4>
                            <p>Join us every Friday for amazing live band performances.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="event-card">
                        <img src="{{ asset('assets/images/event2.jpg') }}" alt="">
                        <div class="event-info">
                            <h4>Karaoke Night</h4>
                            <p>Show your singing talent every Wednesday night.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- Gallery Section -->
    <section id="gallery" class="gallery container">
        <h2 class="text-center mb-4">Gallery</h2>

        <div class="row">
            @foreach(range(1,6) as $g)
            <div class="col-md-4 mb-3">
                <img src="{{ asset('assets/images/gallery'.$g.'.jpg') }}" class="img-fluid rounded" alt="">
            </div>
            @endforeach
        </div>
    </section>


    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="text-center mb-4">Testimonials</h2>

            <div class="row">
                @foreach(range(1,3) as $t)
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/images/user'.$t.'.jpg') }}" alt="">
                        <p>"Amazing experience! I will definitely come back again."</p>
                        <h5>Customer {{ $t }}</h5>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>


    <!-- Contact Section -->
    <section id="contact" class="contact-section container">
        <h2 class="text-center mb-4">Contact Us</h2>

        <div class="row">
            <div class="col-md-6">
                <h4>Get in Touch</h4>
                <p><i class="bi bi-geo-alt"></i> 22 Allen Avenue, Ikeja Lagos</p>
                <p><i class="bi bi-telephone"></i> +234 907 322 2299</p>
                <p><i class="bi bi-envelope"></i> info@demanchyslounge.com</p>
            </div>

            <div class="col-md-6">
                <form>
                    <input type="text" class="form-control mb-3" placeholder="Your Name">
                    <input type="email" class="form-control mb-3" placeholder="Your Email">
                    <textarea class="form-control mb-3" rows="4" placeholder="Message"></textarea>
                    <button class="btn btn-warning w-100">Send Message</button>
                </form>
            </div>
        </div>

    </section>


    <!-- Footer -->
    <footer class="footer text-center">
        <p>© 2024 De Manchys Lounge. All Rights Reserved.</p>
    </footer>


    <!-- AUTH MODAL -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 rounded-4">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Welcome to De Manchys Lounge</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center px-4">
                    <p class="text-muted mb-4">
                        We're excited to have you here!  
                        Login or create an account to enjoy a personalized experience.
                    </p>

                    <a href="/login" class="btn btn-warning w-100 mb-3 fw-semibold">Login</a>
                    <a href="/register" class="btn btn-outline-dark w-100 fw-semibold">Create an Account</a>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
