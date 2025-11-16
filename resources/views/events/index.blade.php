@extends('layouts.app')

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <h1 class="fw-bold mb-4 text-center">Upcoming Events</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($events->count() == 0)
            <p class="text-center text-muted">No events available yet.</p>
        @else
            <div class="row gy-4">

                @foreach($events as $event)
                    <div class="col-md-4">
                        <div class="card shadow rounded-4">
                            <img src="{{ asset('storage/' . $event->image) }}"
                                 class="card-img-top rounded-top-4"
                                 alt="{{ $event->title }}">

                            <div class="card-body">
                                <h5 class="fw-bold">{{ $event->title }}</h5>

                                <p class="small text-muted mb-1">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}
                                </p>

                                <p class="small text-muted mb-2">
                                    <i class="bi bi-geo-alt"></i> {{ $event->location ?? 'Not specified' }}
                                </p>

                                <p class="small">
                                    {{ Str::limit($event->description, 90) }}
                                </p>

                                <a href="{{ route('events.show', $event->id) }}"
                                   class="btn btn-warning w-100 fw-bold">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="mt-4">
                {{ $events->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
