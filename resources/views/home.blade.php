@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="hero d-flex">
  <div class="hero-content">
    <h1>Experience Luxury at<br /><span>De Manchys Lounge</span></h1>
    <p>
      Where exceptional cuisine meets world-class entertainment.<br />
      Featuring the best DJs, state-of-the-art security, and professionally
      trained staff.
    </p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="#" class="btn btn-orange px-4 py-2">Book Your Table</a>
      <a href="{{ url('menu') }}" class="btn btn-outline-light px-4 py-2">View Menu</a>
    </div>
  </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="fw-bold text-black mb-2">Gallery</h2>
    <p class="text-warning mb-4">Take a glimpse into our luxurious atmosphere</p>

    <div id="loungeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <!-- Indicators -->
      <div class="carousel-indicators">
        @for ($i = 0; $i < 6; $i++)
          <button type="button" data-bs-target="#loungeCarousel" data-bs-slide-to="{{ $i }}" 
            class="{{ $i === 0 ? 'active' : '' }}"></button>
        @endfor
      </div>

      <!-- Carousel Images -->
      <div class="carousel-inner rounded-4 shadow-lg overflow-hidden">

        <div class="carousel-item active">
          <img src="{{ asset('assets/security.jpg') }}" class="d-block w-100" alt="Lounge" />
        </div>

        <div class="carousel-item">
          <img src="{{ asset('assets/grilled_meat.jpg') }}" class="d-block w-100" alt="Lounge" />
        </div>

        <div class="carousel-item">
          <img src="{{ asset('assets/lounge_outside.jpg') }}" class="d-block w-100" alt="Lounge" />
        </div>

        <div class="carousel-item">
          <img src="{{ asset('assets/staff.jpg') }}" class="d-block w-100" alt="Lounge" />
        </div>

        <div class="carousel-item">
          <img src="{{ asset('assets/barbecue.jpg') }}" class="d-block w-100" alt="Lounge" />
        </div>

        <div class="carousel-item">
          <img src="{{ asset('assets/drinks.jpg') }}" class="d-block w-100" alt="Lounge" />
        </div>

      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#loungeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
      </button>

      <button class="carousel-control-next" type="button" data-bs-target="#loungeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
      </button>

    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section id="choose-us" class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg-6 mb-4">
        <h2 class="fw-bold text-black mb-3">Why Choose De Manchys Lounge?</h2>
        <p class="text-muted mb-3">
          At De Manchys Lounge, we've created more than just a dining destination –
          we've crafted an experience...
        </p>
        <p class="text-muted">
          Whether you're looking for an intimate dinner, a night out with friends, or a special celebration…
        </p>
      </div>

      <div class="col-lg-6">

        <div class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm mb-3">
          <div class="icon bg-warning text-white rounded-circle me-3 icon-circle">
            <i class="bi bi-music-note-beamed fs-1"></i>
          </div>
          <div>
            <h5 class="fw-semibold">Best DJs in Town</h5>
            <p class="text-muted">Experience electrifying performances...</p>
          </div>
        </div>

        <div class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm mb-3">
          <div class="icon bg-warning text-white rounded-circle me-3 icon-circle">
            <i class="bi bi-shield-lock fs-1"></i>
          </div>
          <div>
            <h5 class="fw-semibold">State-of-the-Art Security</h5>
            <p class="text-muted">Your safety is our priority...</p>
          </div>
        </div>

        <div class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm">
          <div class="icon bg-warning text-white rounded-circle me-3 icon-circle">
            <i class="bi bi-person-check fs-1"></i>
          </div>
          <div>
            <h5 class="fw-semibold">Professional Staff</h5>
            <p class="text-muted">Our well-trained team delivers exceptional service...</p>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- Menu Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold text-black">Our Exquisite Menu</h2>
      <p class="text-muted">Discover a culinary journey...</p>
    </div>

    <div class="d-flex justify-content-center mb-5">
      <div class="p-4 bg-white shadow rounded d-flex align-items-center gap-4">
        <div class="text-center">
          <div class="rounded-circle bg-warning p-3 text-white mx-auto mb-2 icon-circle">
            <i class="fa-solid fa-utensils"></i>
          </div>
          <h6 class="fw-bold">Dine In</h6>
          <small class="text-muted">Experience luxury</small>
        </div>

        <div class="fw-bold text-muted">or</div>

        <div class="text-center">
          <div class="rounded-circle bg-warning p-3 text-white mx-auto mb-2 icon-circle">
            <i class="bi bi-truck fs-4"></i>
          </div>
          <h6 class="fw-bold">Delivery</h6>
          <small class="text-muted">Enjoy at home</small>
        </div>
      </div>
    </div>

    <div class="row g-4">

      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ asset('assets/afang.jpg') }}" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
            <h5 class="fw-bold">Local & International Cuisine</h5>
            <p class="text-muted small">Savor authentic specialties…</p>
            <a href="{{ url('menu') }}" class="btn btn-warning w-100 mt-auto">Order Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ asset('assets/drinks.jpg') }}" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
            <h5 class="fw-bold">Premium Drinks</h5>
            <p class="text-muted small">Refreshing stories...</p>
            <a href="#" class="btn btn-warning w-100 mt-auto">Order Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ asset('assets/grilled_meat.jpg') }}" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
            <h5 class="fw-bold">Grilled Specialties</h5>
            <p class="text-muted small">Expertly grilled meats...</p>
            <a href="#" class="btn btn-warning w-100 mt-auto">Order Now</a>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- Events -->
<section class="py-5 bg-white">
  <div class="container">

    <div class="text-center mb-4">
      <h2 class="fw-bold text-black">Events & Entertainment</h2>
      <p class="text-muted">Experience unforgettable nights…</p>
    </div>

    <div class="row align-items-center g-4">

      <div class="col-md-6">
        <div class="p-4 rounded shadow-sm bg-light-custom">

          <h5 class="fw-bold mb-3 text-black">Upcoming Events</h5>

          <div class="bg-white p-3 mb-3 rounded shadow-sm d-flex justify-content-between">
            <div>
              <h6 class="fw-bold text-muted">Friday Night Live</h6>
              <small class="text-muted">DJ Marcus</small>
            </div>
            <div class="text-end">
              <div class="fw-bold text-warning">Nov 14</div>
              <small class="text-muted">9:00 PM</small>
            </div>
          </div>

          <div class="bg-white p-3 mb-3 rounded shadow-sm d-flex justify-content-between">
            <div>
              <h6 class="fw-bold text-muted">Saturday Vibes</h6>
              <small class="text-muted">Bush Meat Night</small>
            </div>
            <div class="text-end">
              <div class="fw-bold text-warning">Nov 15</div>
              <small class="text-muted">8:30 PM</small>
            </div>
          </div>

          <a href="{{ url('events') }}" class="btn btn-warning w-100 fw-bold">View All Events</a>

        </div>
      </div>

      <div class="col-md-6">
        <img src="{{ asset('assets/partying.jpg') }}" class="img-fluid rounded shadow-sm" />
      </div>

    </div>

    <div class="row text-center mt-5 g-4">

      <div class="col-md-6">
        <div class="p-4 rounded shadow-sm bg-light-custom">
          <div class="rounded-circle bg-warning text-white mx-auto mb-3 d-flex justify-content-center align-items-center icon-circle">
            <i class="bi bi-calendar-event fs-4"></i>
          </div>
          <h6 class="fw-bold text-black">Private Events</h6>
          <p class="text-muted small">Host your occasions with us</p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="p-4 rounded shadow-sm bg-light-custom">
          <div class="rounded-circle bg-warning text-white mx-auto mb-3 d-flex justify-content-center align-items-center icon-circle">
            <i class="bi bi-mic-fill fs-4"></i>
          </div>
          <h6 class="fw-bold text-black">Live Entertainment</h6>
          <p class="text-muted small">Weekly performances</p>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- Visit Us -->
<section class="visit-us py-5">
  <div class="container">

    <div class="text-center mb-4">
      <h2 class="fw-bold text-black">Visit Us Today</h2>
      <p class="text-muted">Find us, contact us, or make a reservation…</p>
    </div>

    <div class="row g-4 align-items-center">

      <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4 rounded-4">

          <h5 class="fw-semibold mb-3">Contact Information</h5>

          <div class="d-flex align-items-start mb-3 contact-item">
            <div class="icon bg-warning text-white rounded-circle">
              <i class="bi bi-geo-alt-fill fs-5"></i>
            </div>
            <div>
              <strong>Address</strong><br />
                 Edet Akpan Avenue (4 Lanes), Beside New Birth Church Junction,<br>
                   Uyo, Akwa Ibom State.
            
            </div>
          </div>

          <div class="d-flex align-items-start mb-3 contact-item">
            <div class="icon bg-warning text-white rounded-circle">
              <i class="bi bi-telephone-fill fs-5"></i>
            </div>
            <div>
              <strong>Phone</strong><br />
              +234 801 277 4355<br />
              +234 901 265 0100
            </div>
          </div>

          <div class="d-flex align-items-start mb-4 contact-item">
            <div class="icon bg-warning text-white rounded-circle">
              <i class="bi bi-envelope-fill fs-5"></i>
            </div>
            <div>
              <strong>Email</strong><br />
              info@demanchyslounge.com<br />
              reservations@demanchyslounge.com
            </div>
          </div>

          <div class="d-flex gap-3 mt-3 social-icons">
            <a href="https://web.facebook.com/profile.php?id=61563811326818" class="text-white bg-warning social-icon">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="text-white bg-warning social-icon">
              <i class="bi bi-instagram"></i>
            </a>
            <a href="#" class="text-white bg-warning social-icon">
              <i class="bi bi-x"></i>
            </a>
            <a href="#" class="text-white bg-warning social-icon">
              <i class="bi bi-whatsapp"></i>
            </a>
          </div>

        </div>
      </div>

      <div class="col-lg-6">
        <div class="map-container shadow-sm rounded-4 overflow-hidden">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2869.512669099262!2d7.952378599717506!3d5.007674207464396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1067f801481c7377%3A0x690b016fc5f0dcdd!2sNew%20Birth%20Bible%20Church%2C%20New%20Avenue%2C!5e0!3m2!1sen!2sng!4v1763185422750!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-light">
  <div class="container">

    <div class="text-center mb-5">
      <h2 class="fw-bold text-black">What Our Guests Say</h2>
      <p class="text-muted">Hear from our valued guests…</p>
    </div>

    <div class="row g-4">

      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
          <img src="{{ asset('assets/woman_1.jpg') }}" class="rounded-circle mb-3" width="80" height="80">
          <h6 class="fw-bold mb-0">Amaka O.</h6>
          <small class="text-muted">Food Enthusiast</small>
          <p class="text-muted fst-italic">“Absolutely loved the jollof rice...”</p>
          <div class="text-warning">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-half"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
          <img src="{{ asset('assets/man1.jpg') }}" class="rounded-circle mb-3" width="80" height="80">
          <h6 class="fw-bold mb-0">Tunde B.</h6>
          <small class="text-muted">Event Host</small>
          <p class="text-muted fst-italic">“Hosted a private event...”</p>
          <div class="text-warning">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
          <img src="{{ asset('assets/woman_2.jpg') }}" class="rounded-circle mb-3" width="80" height="80">
          <h6 class="fw-bold mb-0">Lara S.</h6>
          <small class="text-muted">Lifestyle Blogger</small>
          <p class="text-muted fst-italic">“A hidden gem…”</p>
          <div class="text-warning">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- AUTH MODAL -->
<div class="modal fade" id="authModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3 rounded-4">

      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Welcome to De Manchys Lounge</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center px-4">
        <p class="text-light mb-4">We're excited to have you here!</p>

        <a href="{{ url('login') }}" class="btn btn-warning w-100 mb-3 fw-semibold">Login</a>
        <a href="{{ url('register') }}" class="btn btn-outline-light w-100 fw-semibold">Create an Account</a>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/script.js') }}"></script>
@endpush
