@extends('admin.layouts.app')

@section('title', 'Bookings Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">📋 Bookings Management</h1>
                <div class="btn-group">
                    <a href="{{ route('admin.bookings.today') }}" class="btn btn-warning">
                        <i class="bi bi-calendar-day"></i> Today's Bookings
                    </a>
                    <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-info">
                        <i class="bi bi-calendar-month"></i> Calendar View
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Total Bookings</h6>
                            <h4 class="mb-0">{{ $totalCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-calendar-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Pending</h6>
                            <h4 class="mb-0">{{ $pendingCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-clock fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Confirmed</h6>
                            <h4 class="mb-0">{{ $confirmedCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Today</h6>
                            <h4 class="mb-0">{{ $todayCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-calendar-event fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-body py-3">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-2">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="search" 
                               placeholder="Search by name, email, phone..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="btn-group w-100">
                        <button type="submit" name="today" value="1" class="btn btn-warning btn-sm">
                            <i class="bi bi-calendar-day"></i> Today
                        </button>
                        <button type="submit" name="upcoming" value="1" class="btn btn-info btn-sm">
                            <i class="bi bi-calendar-week"></i> Upcoming
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card shadow">
        <div class="card-body p-0">
            @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Customer</th>
                            <th>Date & Time</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Contact</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr class="{{ $booking->is_today ? 'table-info' : '' }}">
                            <td class="ps-3">
                                <div class="fw-semibold">{{ $booking->name }}</div>
                                <small class="text-muted">
                                    Booked: {{ $booking->created_at->format('M d, Y') }}
                                </small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $booking->formatted_date }}</div>
                                <small class="text-muted">{{ $booking->formatted_time }}</small>
                                @if($booking->is_today)
                                <span class="badge bg-info ms-2">Today</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-dark">{{ $booking->guests }}</span> guests
                            </td>
                            <td>
                                <span class="badge bg-{{ $booking->status_badge }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="small">
                                    <div><i class="bi bi-telephone me-1"></i> {{ $booking->phone }}</div>
                                    @if($booking->email)
                                    <div><i class="bi bi-envelope me-1"></i> {{ $booking->email }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" 
                                       class="btn btn-outline-primary" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#statusModal{{ $booking->id }}"
                                            title="Change Status">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this booking?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Status Change Modal -->
                        <div class="modal fade" id="statusModal{{ $booking->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Booking Status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="status{{ $booking->id }}" class="form-label">New Status</label>
                                                <select class="form-select" id="status{{ $booking->id }}" name="status" required>
                                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="no_show" {{ $booking->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="notes{{ $booking->id }}" class="form-label">Admin Notes</label>
                                                <textarea class="form-control" id="notes{{ $booking->id }}" name="admin_notes" 
                                                          rows="3" placeholder="Add notes about this status change...">{{ $booking->admin_notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-3 border-top">
                {{ $bookings->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                <h5 class="mt-3">No Bookings Found</h5>
                <p class="text-muted">
                    @if(request('search') || request('status') || request('today') || request('upcoming'))
                    Try changing your search criteria
                    @else
                    No bookings yet. Check back later!
                    @endif
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection