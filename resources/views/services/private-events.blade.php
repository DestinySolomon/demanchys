@extends('layouts.app')

@section('content')

<section class="py-5 text-center text-light"
    style="background: url('{{ asset('assets/private_event.jpg') }}') center/cover no-repeat; height:50vh;">
    <div class="container">
        <h1 class="display-5 fw-bold text-warning">Private Events at De Manchys Lounge</h1>
        <p class="lead mt-3">
            Experience a premium and intimate atmosphere tailored for birthdays, proposals, anniversaries, 
            reunions, and exclusive celebrations. We create unforgettable moments with class and comfort.
        </p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4 text-dark">Why Choose Us?</h2>
        <p class="text-dark">
            Our private events service gives you exclusive access to beautifully curated spaces, 
            personalized décor, premium dining options, and exceptional hospitality. 
            Whether you're hosting a small indoor gathering or a premium lounge experience, 
            our team ensures a flawless and memorable event.
        </p>

        <a href="{{ url('/reservation') }}" class="btn btn-warning mt-3">Book a Private Event</a>
    </div>
</section>

@endsection
