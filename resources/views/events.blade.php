@extends('layouts.app')

@section('content')

<!-- HERO / BANNER -->
<section class="events-hero d-flex align-items-center text-center text-light"
         style="background: url({{ asset('assets/events_header.jpg') }}) center/cover no-repeat; height: 60vh;">
    <div class="w-100 bg-dark bg-opacity-50 py-5">
        <h1 class="display-4 fw-bold">Upcoming Events</h1>
        <p class="lead mt-3 mx-auto" style="max-width: 650px;">
            Discover unforgettable nights at De Manchys Lounge - from live music and themed parties to exclusive VIP gatherings.
        </p>
    </div>
</section>


<!-- EVENTS SECTION -->
<section class="py-5 bg-light">
    <div class="container">

        <h2 class="fw-bold text-center mb-4 text-dark">Experience the Vibes</h2>
        <p class="text-center text-warning mb-5">
            Explore our curated lineup of premium events crafted just for you.
        </p>

        <div class="row g-4">

            <!-- EVENT CARD 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <img src="{{ asset('assets/event1.jpg') }}" class="card-img-top" alt="Event Image">

                    <div class="card-body p-4">
                        <span class="badge bg-warning text-dark mb-2 fw-semibold">Friday • 9PM</span>

                        <h5 class="fw-bold">Live Music Night</h5>
                        <p class="text-muted small mt-2">
                            Enjoy soulful live performances by top artists, great food, and premium drinks all in one unforgettable evening.
                        </p>

                        <a href="#" class="btn btn-orange w-100 mt-3">Reserve a Spot</a>
                    </div>
                </div>
            </div>

            <!-- EVENT CARD 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <img src="{{ asset('assets/event2.jpg') }}" class="card-img-top" alt="Event Image">

                    <div class="card-body p-4">
                        <span class="badge bg-warning text-dark mb-2 fw-semibold">Saturday • 8PM</span>

                        <h5 class="fw-bold">Classic African Night</h5>
                        <p class="text-muted small mt-2">
                            A taste of culture -smooth rhythms, drums, dances, and the rich African vibes you love.
                        </p>

                        <a href="#" class="btn btn-orange w-100 mt-3">Book Your Seat</a>
                    </div>
                </div>
            </div>

            <!-- EVENT CARD 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <img src="{{ asset('assets/event3.jpg') }}" class="card-img-top" alt="Event Image">

                    <div class="card-body p-4">
                        <span class="badge bg-warning text-dark mb-2 fw-semibold">Sunday • 7PM</span>

                        <h5 class="fw-bold">Wine & Chill Evening</h5>
                        <p class="text-muted small mt-2">
                            Relax with fine wines, cozy ambiance, exquisite meals, and an atmosphere perfect for unwinding.
                        </p>

                        <a href="#" class="btn btn-orange w-100 mt-3">Join the Experience</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- VIP HIGHLIGHT BANNER -->
<section class="py-5 text-light"
         style="background: url({{ asset('assets/vip_banner.jpg') }}) center/cover no-repeat;">
    <div class="bg-dark bg-opacity-50 py-5">
        <div class="container text-center">
            <h2 class="fw-bold display-6">Host Your Private Events</h2>
            <p class="mt-3 mx-auto" style="max-width: 700px;">
                From corporate meetings to birthday celebrations and exclusive VIP hangouts,  
                our lounge is designed to deliver premium comfort and unforgettable luxury.
            </p>
            <a href="#" class="btn btn-warning text-dark px-4 py-2 mt-3 fw-semibold">Book a Private Hall</a>
        </div>
    </div>
</section>


@endsection
