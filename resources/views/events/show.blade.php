@extends('layouts.app')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow rounded-4">
                    @if($event->image_url)
                        <img src="{{ $event->image_url }}" class="card-img-top rounded-top-4" alt="{{ $event->title }}">
                    @endif

                    <div class="card-body">
                        <h1 class="fw-bold mb-2">{{ $event->title }}</h1>

                        <p class="small text-muted mb-1">
                            <i class="bi bi-calendar-event"></i>
                            {{ $event->event_date->format('F j, Y g:i A') }}
                        </p>

                        <p class="small text-muted mb-2"><i class="bi bi-geo-alt"></i>
                            {{ $event->location ?? 'Not specified' }}</p>

                        <div class="mb-3">
                            <span class="badge {{ $event->event_type_badge_class }}">{{ $event->event_type_label }}</span>
                            <span class="badge {{ $event->status_badge_class }}">{{ $event->status_label }}</span>
                        </div>

                        <p class="lead">{{ $event->description }}</p>

                        @if(!$event->isFree())
                            <div class="mb-3"><strong>Price:</strong> {{ $event->formatted_price }}</div>
                        @else
                            <div class="mb-3"><strong>Price:</strong> Free</div>
                        @endif

                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary me-2">← Back to events</a>
                        <a href="{{ url('/') }}" class="btn btn-outline-dark">Back Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
