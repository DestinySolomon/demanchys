@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Past Events</h1>
        <div class="btn-group">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">All Events</a>
            <a href="{{ route('admin.events.upcoming') }}" class="btn btn-outline-success">Upcoming Events</a>
            <a href="{{ route('admin.events.ongoing') }}" class="btn btn-outline-warning">Ongoing Events</a>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Create Event
            </a>
        </div>
    </div>

    <!-- Past Events Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Past Events ({{ $events->total() }})</h6>
        </div>
        <div class="card-body">
            @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Attendance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>
                                <strong>{{ $event->title }}</strong>
                                @if($event->category)
                                    <br><small class="text-muted">{{ $event->category }}</small>
                                @endif
                            </td>
                            <td>
                                <small>{{ $event->getFormattedEventDateAttribute() }}</small>
                                <br>
                                <small class="text-muted">
                                    {{ $event->event_date->diffForHumans() }}
                                </small>
                            </td>
                            <td>
                                <span class="badge {{ $event->event_type_badge_class }}">
                                    {{ $event->event_type_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $event->status_badge_class }}">
                                    {{ $event->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($event->capacity)
                                    <small class="text-muted">Capacity: {{ $event->capacity }}</small>
                                @else
                                    <span class="text-muted">No data</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.events.show', $event->id) }}" 
                                   class="btn btn-sm btn-info me-1" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event->id) }}" 
                                   class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $events->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No Past Events</h4>
                <p class="text-muted">There are no past events in the system.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection