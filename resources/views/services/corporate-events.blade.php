@extends('layouts.app')

@section('content')

<section class="py-5 text-center text-light"
    style="background: url('{{ asset('assets/corporate.jpg') }}') center/cover no-repeat; height:50vh;">
    <div class="container">
        <h1 class="display-5 fw-bold text-warning">Corporate Events & Business Functions</h1>
        <p class="lead mt-3">
            Host your team meetings, business dinners, product launches, and networking sessions 
            in a classy and professionally curated environment designed for excellence and comfort.
        </p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4 text-dark">Perfect for Your Brand</h2>
        <p class="text-dark">
            We offer structured layouts, technical arrangements, premium hospitality, and flexible setups 
            to accommodate small and large teams. Give your partners and staff an unforgettable business experience.
        </p>

        <a href="{{ url('/reservation') }}" class="btn btn-warning mt-3">Schedule Corporate Booking</a>
    </div>
</section>

@endsection
