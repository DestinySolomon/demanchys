@extends('layouts.app')

@section('content')

<section class="py-5 text-center text-light"
    style="background: url('{{ asset('assets/catering.jpg') }}') center/cover no-repeat; height:50vh;">
    <div class="container">
        <h1 class="display-5 fw-bold text-warning">Catering Services</h1>
        <p class="lead mt-3">
            Let De Manchys Lounge bring exquisite meals, flawless presentation, and premium hospitality to your event.  
            We provide catering for weddings, corporate events, birthdays, and private gatherings.
        </p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4 text-dark">What We Offer</h2>
        <p class="text-dark">
            From local delicacies to international cuisine, our chefs prepare meals with top-quality ingredients, 
            rich flavors, and professional plating. We handle everything—buffet setup, delivery, and on-site service-so you can relax 
            and enjoy your event without stress.
        </p>

        <a href="{{ url('/reservation') }}" class="btn btn-warning mt-3">Request Catering</a>
    </div>
</section>

@endsection
