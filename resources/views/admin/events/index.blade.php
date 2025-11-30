@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Events Management</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Create New Event
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $events->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-event fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Upcoming Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Ongoing Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ongoingCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-play-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Past Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pastCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Events Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Events</h6>
        </div>
        <div class="card-body">
            @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" id="eventsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Event Title</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td class="text-center">
                                @php $imgSrc = $event->image_url ?? asset('assets/placeholder_food.jpg'); @endphp
                                <img src="{{ $imgSrc }}"
                                     alt="{{ $event->title }}"
                                     class="rounded bg-light"
                                     style="width: 60px; height: 60px; object-fit: cover; display: block;"
                                     onerror="this.onerror=null; this.src='{{ asset('assets/placeholder_food.jpg') }}'">
                            </td>
                            <td>
                                <strong>{{ $event->title }}</strong>
                                @if($event->category)
                                    <br><small class="text-muted">{{ $event->category }}</small>
                                @endif
                            </td>
                            <td>
                                <small>{{ $event->getFormattedEventDateAttribute() }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $event->event_type_badge_class }}">
                                    {{ $event->event_type_label }}
                                </span>
                            </td>
                            <td>
                                @if($event->location)
                                    {{ Str::limit($event->location, 30) }}
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $event->formatted_price }}</strong>
                            </td>
                            <td>
                                <span class="badge {{ $event->status_badge_class }}">
                                    {{ $event->status_label }}
                                </span>
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
                                <button class="btn btn-sm btn-danger delete-event" 
                                        data-id="{{ $event->id }}"
                                        data-title="{{ $event->title }}"
                                        title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $events->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No Events Found</h4>
                <p class="text-muted">Get started by creating your first event.</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create First Event
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Event Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<strong id="deleteEventTitle"></strong>"?</p>
                <p class="text-danger small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    This action cannot be undone. All event data will be permanently deleted.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteEventForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Event Modal
        document.querySelectorAll('.delete-event').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                
                document.getElementById('deleteEventTitle').textContent = title;
                document.getElementById('deleteEventForm').action = '{{ url('admin/events') }}/' + id;
                
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteEventModal'));
                deleteModal.show();
            });
        });
    });
</script>
@endpush

<style>
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
}
.bg-pink { background-color: #e83e8c !important; }
.bg-purple { background-color: #6f42c1 !important; }
.bg-wine { background-color: #8b0000 !important; }
.bg-orange { background-color: #fd7e14 !important; }
</style>
@endsection