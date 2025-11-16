@extends('layouts.app')

@section('content')

<!-- EVENTS HERO -->
<section class="events-hero d-flex align-items-center text-center text-light"
    style="background: url('{{ asset('assets/lounge_events.jpg') }}') center/cover no-repeat; height: 50vh;">
    <div class="container">
        <h1 class="display-4 fw-bold text-warning">Upcoming & Past Events</h1>
        <p class="lead mt-3">
            Explore our curated lineup of premium entertainment — concerts, comedy nights, karaoke sessions, parties & more.
        </p>
    </div>
</section>

<!-- FILTERS -->
<section class="py-4 bg-light">
    <div class="container">
        <form method="GET" action="{{ route('events.index') }}" class="row g-3 justify-content-center">

            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="Concert" {{ request('category')=='Concert' ? 'selected' : '' }}>Concert</option>
                    <option value="Comedy" {{ request('category')=='Comedy' ? 'selected' : '' }}>Comedy</option>
                    <option value="Karaoke" {{ request('category')=='Karaoke' ? 'selected' : '' }}>Karaoke</option>
                    <option value="Party" {{ request('category')=='Party' ? 'selected' : '' }}>Party</option>
                </select>
            </div>

            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Upcoming" {{ request('status')=='Upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="Past" {{ request('status')=='Past' ? 'selected' : '' }}>Past</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-warning w-100 fw-bold">Filter</button>
            </div>

        </form>
    </div>
</section>

<!-- EVENTS LIST -->
<section class="py-5">
    <div class="container">

        <div class="row gy-5">

            @forelse ($events as $event)
            <div class="col-md-4">
                <div class="card shadow rounded-4 overflow-hidden">

                    <img src="{{ asset('storage/' . $event->image) }}"
                        class="card-img-top" height="220" style="object-fit: cover" alt="{{ $event->title }}">

                    <div class="card-body">

                        <span class="badge bg-warning text-dark mb-2">{{ $event->category }}</span>

                        <h5 class="fw-bold text-dark">{{ $event->title }}</h5>

                        <p class="small text-muted mb-2">
                            {!! Str::limit($event->description, 120) !!}
                        </p>

                        <p class="small fw-semibold text-dark">
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                        </p>

                        <span
                            class="badge {{ $event->status == 'Upcoming' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $event->status }}
                        </span>

                    </div>
                </div>
            </div>
            @empty

            <div class="col-12 text-center py-5">
                <h5 class="text-muted">No events available.</h5>
            </div>

            @endforelse

        </div>

        <div class="mt-4">
            {{ $events->links() }}
        </div>

    </div>
</section>

@endsection
