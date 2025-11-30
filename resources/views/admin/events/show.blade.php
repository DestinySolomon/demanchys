@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Event Details</h1>
        <div class="btn-group">
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Events
            </a>
            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit Event
            </a>
        </div>
    </div>

    <!-- Event Information -->
    <div class="row">
        <!-- Left Column - Event Details -->
        <div class="col-lg-8">
            <!-- Event Summary Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Event Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Event Title:</strong> {{ $event->title }}</p>
                            <p><strong>Event Type:</strong> 
                                <span class="badge {{ $event->event_type_badge_class }}">
                                    {{ $event->event_type_label }}
                                </span>
                            </p>
                            <p><strong>Category:</strong> 
                                {{ $event->category ?: 'Not specified' }}
                            </p>
                            <p><strong>Date & Time:</strong> {{ $event->getFormattedEventDateAttribute() }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong>
                                <span class="badge {{ $event->status_badge_class }}">
                                    {{ $event->status_label }}
                                </span>
                            </p>
                            <p><strong>Location:</strong> 
                                {{ $event->location ?: 'Not specified' }}
                            </p>
                            <p><strong>Capacity:</strong> 
                                {{ $event->capacity ? $event->capacity . ' people' : 'Unlimited' }}
                            </p>
                            <p><strong>Price:</strong> 
                                <strong>{{ $event->formatted_price }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Event Description</h6>
                </div>
                <div class="card-body">
                    <p>{{ $event->description }}</p>
                </div>
            </div>

            <!-- Event Image Card -->
            @if($event->image_url)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Event Image</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $event->image_url }}" 
                         alt="{{ $event->title }}" 
                         class="img-fluid rounded" 
                         style="max-height: 400px; object-fit: cover;"
                         onerror="this.style.display='none'">
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Actions & Contact -->
        <div class="col-lg-4">
            <!-- Status Update Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.update-status', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Event Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" {{ $event->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $event->status === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="cancelled" {{ $event->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ $event->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
                </div>
                <div class="card-body">
                    @if($event->contact_email || $event->contact_phone)
                        @if($event->contact_email)
                            <p><strong>Email:</strong> {{ $event->contact_email }}</p>
                        @endif
                        @if($event->contact_phone)
                            <p><strong>Phone:</strong> {{ $event->contact_phone }}</p>
                        @endif
                    @else
                        <p class="text-muted">No contact information provided</p>
                    @endif
                </div>
            </div>

            <!-- Event Timeline Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Event Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Created</small>
                        <p class="mb-0">{{ $event->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Last Updated</small>
                        <p class="mb-0">{{ $event->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <small class="text-muted">Event Date</small>
                        <p class="mb-0">{{ $event->getFormattedEventDateAttribute() }}</p>
                        <small class="text-{{ $event->isUpcoming() ? 'success' : ($event->isOngoing() ? 'warning' : 'muted') }}">
                            @if($event->isUpcoming())
                                <i class="bi bi-clock me-1"></i>Upcoming - {{ $event->event_date->diffForHumans() }}
                            @elseif($event->isOngoing())
                                <i class="bi bi-play-circle me-1"></i>Ongoing
                            @else
                                <i class="bi bi-check-circle me-1"></i>Past - {{ $event->event_date->diffForHumans() }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <!-- Delete Event Card -->
            <div class="card shadow border-danger">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Danger Zone</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Once you delete this event, there is no going back. Please be certain.</p>
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete This Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection