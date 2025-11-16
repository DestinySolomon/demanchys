@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="text-center text-light d-flex align-items-center justify-content-center"
    style="background: url('{{ asset('assets/lounge_outside.jpg') }}') center/cover no-repeat; height: 40vh;">
    <div>
        <h1 class="fw-bold display-4 text-warning">Our Gallery</h1>
        <p class="lead">Explore moments, ambience, events and experiences at De Manchys Lounge</p>
    </div>
</section>

<!-- FILTER BUTTONS -->
<section class="py-4 bg-light">
    <div class="container text-center">

        <h4 class="fw-bold mb-3 text-dark">Filter by Category</h4>

        <div class="btn-group">

            @php
                $categories = ['Food', 'Events', 'Lounge', 'Drinks'];
            @endphp

            <a href="{{ route('gallery.index') }}"
               class="btn btn-outline-dark {{ !$category ? 'active' : '' }}">
                All
            </a>

            @foreach ($categories as $cat)
                <a href="{{ route('gallery.index', ['category' => $cat]) }}"
                   class="btn btn-outline-dark {{ $category === $cat ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach

        </div>

    </div>
</section>

<!-- GALLERY GRID -->
<section class="py-5">
    <div class="container">

        @if($images->count() == 0)
            <p class="text-center text-white-50">No images added yet for this category.</p>
        @endif

        <div class="row g-4">

            @foreach ($images as $img)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <img src="{{ asset('storage/' . $img->image_path) }}"
                             class="card-img-top"
                             style="height: 260px; object-fit: cover;"
                             alt="Gallery Image">

                        <div class="card-body text-center">
                            <span class="badge bg-dark">{{ $img->category }}</span>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- PAGINATION -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $images->links() }}
        </div>

    </div>
</section>

@endsection
