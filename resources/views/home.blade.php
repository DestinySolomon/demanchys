@extends('layouts.app')

@section('content')

<!-- Gold Bubble Animation Layer -->
<div id="gold-bubbles">
    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>
    <div class="bubble bubble-4"></div>
    <div class="bubble bubble-5"></div>
    <div class="bubble bubble-6"></div>
    <div class="bubble bubble-7"></div>
    <div class="bubble bubble-8"></div>
    <div class="bubble bubble-9"></div>
    <div class="bubble bubble-10"></div>
</div>

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
      <a href="{{ route('book.table') }}" class="btn btn-warning">Book Your Table</a>

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
            class="{{ $i === 0 ? 'active' : '' }} bg-warning"></button>
        @endfor
      </div>

      <!-- Carousel Images - FIXED FOR MOBILE -->
      <div class="carousel-inner rounded-4 shadow-lg overflow-hidden">
        <div class="carousel-item active">
          <img src="{{ asset('assets/security.jpg') }}" class="d-block w-100 gallery-image" alt="Security" />
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/grilled_meat.jpg') }}" class="d-block w-100 gallery-image" alt="Grilled Meat" />
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/lounge_outside.jpg') }}" class="d-block w-100 gallery-image" alt="Lounge Exterior" />
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/staff.jpg') }}" class="d-block w-100 gallery-image" alt="Our Staff" />
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/barbecue.jpg') }}" class="d-block w-100 gallery-image" alt="Barbecue" />
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/drinks.jpg') }}" class="d-block w-100 gallery-image" alt="Drinks" />
        </div>
      </div>

      <!-- Controls - FIXED FOR MOBILE -->
      <button class="carousel-control-prev" type="button" data-bs-target="#loungeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2 p-md-3"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#loungeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-2 p-md-3"></span>
      </button>

    </div>
  </div>
</section>

@push('styles')
<style>
    /* Gallery Carousel Images - Mobile First */
    .gallery-image {
        height: 200px; /* Small on mobile */
        object-fit: cover;
        width: 100%;
    }
    
    /* Tablet */
    @media (min-width: 576px) {
        .gallery-image {
            height: 250px;
        }
    }
    
    /* Small Desktop */
    @media (min-width: 768px) {
        .gallery-image {
            height: 300px;
        }
    }
    
    /* Large Desktop */
    @media (min-width: 992px) {
        .gallery-image {
            height: 350px;
        }
    }
    
    /* Extra Large */
    @media (min-width: 1200px) {
        .gallery-image {
            height: 400px;
        }
    }
    
    /* Gallery Carousel Controls - Smaller on Mobile */
    #loungeCarousel .carousel-control-prev,
    #loungeCarousel .carousel-control-next {
        width: 10%;
    }
    
    #loungeCarousel .carousel-control-prev-icon,
    #loungeCarousel .carousel-control-next-icon {
        width: 20px;
        height: 20px;
        background-size: 50%;
    }
    
    @media (min-width: 768px) {
        #loungeCarousel .carousel-control-prev-icon,
        #loungeCarousel .carousel-control-next-icon {
            width: 30px;
            height: 30px;
        }
    }
    
    /* Gallery Carousel Indicators - Smaller on Mobile */
    #loungeCarousel .carousel-indicators {
        bottom: 5px;
    }
    
    #loungeCarousel .carousel-indicators button {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin: 0 3px;
        border: 0;
    }
    
    @media (min-width: 768px) {
        #loungeCarousel .carousel-indicators button {
            width: 8px;
            height: 8px;
            margin: 0 4px;
        }
    }
</style>
@endpush

<!-- Why Choose Us -->
<section id="choose-us" class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg-6 mb-4">
        <h2 class="fw-bold text-black mb-3">Why Choose De Manchys Lounge?</h2>
         <p class="text-muted mb-3">
              At De Manchys Lounge, we've created more than just a dining
              destination – we've crafted an experience. Our commitment to
              excellence shines through every aspect of our service, from our
              carefully curated menu featuring both local and international
              cuisine to our world-class entertainment and unparalleled
              hospitality.
            </p>
            <p class="text-muted">
              Whether you're looking for an intimate dinner, a night out with
              friends, or a special celebration, our luxurious atmosphere and
              professional service ensure every visit is memorable.
            </p>
      </div>

      <div class="col-lg-6">

        {{-- Card 1 --}}

        <div class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm mb-3">
          <div class="icon bg-warning text-white rounded-circle me-3 icon-circle">
            <i class="bi bi-music-note-beamed fs-1"></i>
          </div>
          <div>
            <h5 class="fw-semibold text-muted">Best DJs in Town</h5>
                <p class="mb-0 text-muted">
                  Experience electrifying performances from top-tier DJs who
                  know how to keep the energy flowing all night long.
                </p>
          </div>
        </div>
          
        {{-- Card 2 --}}
        <div class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm mb-3">
          <div class="icon bg-warning text-white rounded-circle me-3 icon-circle">
            <i class="bi bi-shield-lock fs-1"></i>
          </div>
          <div>
            <h5 class="fw-semibold text-muted">State-of-the-Art Security</h5>
                <p class="mb-0 text-muted">
                  Your safety is our priority. Our advanced security systems and
                  trained personnel ensure a secure environment.
                </p>
          </div>
        </div>


        {{-- Card 3 --}}
        <div class="d-flex align-items-start bg-light p-4 rounded-4 shadow-sm">
          <div class="icon bg-warning text-white rounded-circle me-3 icon-circle">
            <i class="bi bi-person-check fs-1"></i>
          </div>
          <div>
           <h5 class="fw-semibold text-muted">Professional Staff</h5>
                <p class="mb-0 text-muted">
                  Our well-trained team delivers exceptional service with
                  attention to detail that exceeds expectations.
                </p>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- Menu Section -->
<section class="py-5 bg-light">
  <div class="container">
    {{-- section tittle --}}
    <div class="text-center mb-4">
       <h2 class="fw-bold text-black">Our Exquisite Menu</h2>
          <p class="text-muted">
            Discover a culinary journey that spans continents, featuring the
            finest local delicacies <br />
            and international favorites, all prepared by our expert chefs.
          </p>
    </div>

    <div class="d-flex justify-content-center mb-5">
      <div class="p-4 bg-white shadow rounded d-flex align-items-center gap-4">
        <div class="text-center">
          <div class="rounded-circle bg-warning p-3 text-white mx-auto mb-2 icon-circle">
            <i class="fa-solid fa-utensils"></i>
          </div>
          <h6 class="fw-bold">Dine In</h6>
          <small class="text-muted">Experience luxury in our lounge</small>
        </div>

        <div class="fw-bold text-muted">or</div>

        <div class="text-center">
          <div class="rounded-circle bg-warning p-3 text-white mx-auto mb-2 icon-circle">
            <i class="bi bi-truck fs-4"></i>
          </div>
          <h6 class="fw-bold">Delivery</h6>
          <small class="text-muted">Enjoy our food at your doorstep</small>
        </div>
      </div>
    </div>


    {{-- Menu Cards --}}
    <div class="row g-4">
   {{-- Card 1 --}}
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ asset('assets/afang.jpg') }}" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
            <h5 class="fw-bold">Local & International Cuisine</h5>
                <p class="text-muted small">
                  Savor authentic Nigerian specialties alongside carefully
                  crafted international dishes. Each story begins with flavor.
                </p>
            <a href="{{ url('menu') }}" class="btn btn-warning w-100 mt-auto">Order Now</a>
          </div>
        </div>
      </div>
        {{-- Card 2 --}}
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ asset('assets/drinks.jpg') }}" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
             <h5 class="fw-bold">Premium Drinks & Beverages</h5>
                <p class="text-muted small">
                  From cocktails to fine wines, our drink selection brings
                  refreshing stories to every meal.
                </p>
            <a href="#" class="btn btn-warning w-100 mt-auto">Order Now</a>
          </div>
        </div>
      </div>
         {{-- Card 3 --}}
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ asset('assets/grilled_meat.jpg') }}" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
            <h5 class="fw-bold">Grilled Specialties & Snacks</h5>
                <p class="text-muted small">
                  Enjoy expertly grilled meats, fish, and traditional
                  snacks—rich in flavor and perfectly prepared.
                </p>
            <a href="#" class="btn btn-warning w-100 mt-auto">Order Now</a>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
<!-- Promotional Banners Section -->
@if($promotionalBanners->count() > 0)
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-black">Special Promotions</h2>
            <p class="text-muted">Discover our exclusive offers and limited-time deals</p>
        </div>

        <div id="promotionalCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <!-- Indicators -->
            @if($promotionalBanners->count() > 1)
            <div class="carousel-indicators">
                @foreach($promotionalBanners as $key => $banner)
                <button type="button" data-bs-target="#promotionalCarousel" data-bs-slide-to="{{ $key }}" 
                    class="{{ $key === 0 ? 'active' : '' }} bg-warning"></button>
                @endforeach
            </div>
            @endif

            <!-- Carousel Items -->
            <div class="carousel-inner rounded-4 shadow-lg overflow-hidden">
                @foreach($promotionalBanners as $key => $banner)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <div class="position-relative">
                        <!-- Responsive Image - No fixed height -->
                        <img src="{{ Storage::url($banner->image_path) }}" 
                             class="d-block w-100 carousel-image" 
                             alt="{{ $banner->title }}">
                        
                        <!-- Caption for Desktop -->
                        @if($banner->title || $banner->description || $banner->url)
                        <div class="carousel-caption d-none d-md-block caption-overlay">
                            @if($banner->title)
                            <h3 class="text-warning fw-bold mb-2">{{ $banner->title }}</h3>
                            @endif
                            @if($banner->description)
                            <p class="text-white mb-3">{{ $banner->description }}</p>
                            @endif
                            @if($banner->url)
                            <a href="{{ $banner->url }}" class="btn btn-warning btn-sm" target="_blank">
                                Learn More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            @endif
                        </div>
                        
                        <!-- Mobile Caption (Simplified) -->
                        <div class="carousel-caption d-md-none mobile-caption">
                            @if($banner->title)
                            <h6 class="text-warning fw-bold mb-1">{{ $banner->title }}</h6>
                            @endif
                            @if($banner->url)
                            <a href="{{ $banner->url }}" class="btn btn-warning btn-sm" target="_blank">
                                Details
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Controls -->
            @if($promotionalBanners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#promotionalCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2 p-md-3"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#promotionalCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-2 p-md-3"></span>
            </button>
            @endif
        </div>
    </div>
</section>
@else
<div class="text-center py-5">
    <div class="bg-light rounded-4 p-5">
        <i class="bi bi-megaphone text-muted" style="font-size: 4rem;"></i>
        <h5 class="mt-3 text-muted">No Active Promotions</h5>
        <p class="text-muted">Check back later for special offers</p>
    </div>
</div>
@endif
<!-- Offer Deals Section -->
@if($offerDeals->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-black"> Special Offers & Deals</h2>
            <p class="text-muted">Limited-time offers you don't want to miss</p>
        </div>

        <div class="row g-4">
            @foreach($offerDeals as $offer)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="position-relative">
                        <img src="{{ Storage::url($offer->image_path) }}" 
                             class="card-img-top" 
                             alt="{{ $offer->title }}"
                             style="height: 200px; object-fit: cover;">
                        
                        <!-- Offer Status Badge -->
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($offer->start_date && $offer->end_date)
                            <span class="badge bg-warning">
                                {{ $offer->start_date->format('M d') }} - {{ $offer->end_date->format('M d') }}
                            </span>
                            @elseif($offer->start_date)
                            <span class="badge bg-info">Starts: {{ $offer->start_date->format('M d') }}</span>
                            @elseif($offer->end_date)
                            <span class="badge bg-danger">Ends: {{ $offer->end_date->format('M d') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-black">{{ $offer->title ?? 'Special Offer' }}</h5>
                        
                        @if($offer->description)
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($offer->description, 100) }}
                        </p>
                        @endif
                        
                        <div class="mt-auto">
                            @if($offer->url)
                            <a href="{{ $offer->url }}" class="btn btn-outline-warning w-100" target="_blank">
                                View Offer <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            @else
                            <button class="btn btn-outline-warning w-100" disabled>
                                Offer Details
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($offerDeals->count() == 0)
        <div class="text-center py-5">
            <div class="bg-white rounded-4 p-5 shadow-sm">
                <i class="bi bi-tag text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">No Active Offers</h5>
                <p class="text-muted">New offers coming soon!</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endif



<!-- Events -->
<section class="py-5 bg-white">
  <div class="container">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-black">Events & Entertainment</h2>
          <p class="text-muted">
            Experience unforgettable nights with our world-class entertainment
            and exclusive <br />
            events. From DJ nights to private celebrations, we make every moment
            special.
          </p>
    </div>

    <div class="row align-items-center g-4">

      <div class="col-md-6">
        <div class="p-4 rounded shadow-sm bg-light-custom">

          <h5 class="fw-bold mb-3 text-black">Upcoming Events</h5>

          <div class="bg-white p-3 mb-3 rounded shadow-sm d-flex justify-content-between">
            <div>
              <h6 class="fw-bold text-muted">Friday Night Live</h6>
              <small class="text-muted">DJ Marcus and live band</small>
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

              <!-- Event Item -->
              <div
                class="d-flex justify-content-between align-items-center bg-white p-3 mb-3 rounded shadow-sm"
              >
                <div>
                  <h6 class="fw-bold mb-1 text-muted">Wine Tasting Night</h6>
                  <small class="text-muted">Premium Wine Selection</small>
                </div>
                <div class="text-end">
                  <div class="fw-bold text-warning">Nov 22</div>
                  <small class="text-muted">7:00 PM</small>
                </div>
              </div>


          {{-- View All Events Button --}}
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
          <p class="text-muted small">Host your special occasions with us</p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="p-4 rounded shadow-sm bg-light-custom">
          <div class="rounded-circle bg-warning text-white mx-auto mb-3 d-flex justify-content-center align-items-center icon-circle">
            <i class="bi bi-mic-fill fs-4"></i>
          </div>
          <h6 class="fw-bold text-black">Live Entertainment</h6>
          <p class="text-muted small">Weekly performances by top artists</p>
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
          <p class="text-muted">
            Ready to experience luxury dining and entertainment? Find us,
            contact us, or make a reservation. <br />
            We're here to make your visit unforgettable.
          </p>
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
@if($featuredTestimonials->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-black">What Our Guests Say</h2>
            <p class="text-muted">
                Hear from our valued guests who've experienced the taste, ambiance,
                and luxury we bring to every moment. <br />
                Their stories make ours truly unforgettable.
            </p>
        </div>

        <div class="row g-4">
            @foreach($featuredTestimonials as $testimonial)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                    <!-- Customer Image -->
                    @if($testimonial->image)
                        <img src="{{ Storage::url($testimonial->image) }}" 
                             class="rounded-circle mb-3 mx-auto" 
                             alt="{{ $testimonial->name }}"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-person fs-4 text-white"></i>
                        </div>
                    @endif
                    
                    <!-- Customer Name & Designation -->
                    <h6 class="fw-bold mb-1">{{ $testimonial->name }}</h6>
                    @if($testimonial->designation)
                    <small class="text-muted d-block mb-3">{{ $testimonial->designation }}</small>
                    @endif
                    
                    <!-- Testimonial Content -->
                    <p class="text-muted fst-italic mb-3">
                        "{{ $testimonial->content }}"
                    </p>
                    
                    <!-- Star Rating -->
                    <div class="text-warning mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    <small class="text-muted">{{ $testimonial->rating }}/5 rating</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

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