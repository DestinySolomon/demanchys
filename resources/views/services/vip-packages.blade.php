@extends('layouts.app')

@section('content')

<section class="py-5 text-center text-light"
    style="background: url('{{ asset('assets/vip.jpg') }}') center/cover no-repeat; height:50vh;">
    <div class="container">
        <h1 class="display-5 fw-bold text-warning">Exclusive VIP Packages</h1>
        <p class="lead mt-3">
            Enjoy luxury, privacy, and premium treatment with De Manchys' exclusive VIP packages.  
            Perfect for elite guests, high-profile clients, and anyone who desires a special experience.
        </p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4 text-dark">Premium Benefits</h2>
        <p class="text-dark">
            Our VIP packages include reserved lounge seating, priority service, personalized attendants, 
            premium drinks, and curated meal selections. Enjoy your night in grand style with an unmatched sense of comfort.
        </p>

        <a href="{{ url('/reservation') }}" class="btn btn-warning mt-3">Book VIP Experience</a>
    </div>
</section>

@endsection
