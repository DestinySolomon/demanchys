@extends('admin.layouts.app')

@section('title', "Today's Bookings")

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-calendar-day me-2"></i>
                            Today's Bookings - {{ \Carbon\Carbon::today()->format('F d, Y') }}
                        </h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-list-ul me-1"></i> All Bookings
                            </a>
                            <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-calendar-week me-1"></i> Calendar View
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Time Slots Overview -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Bookings by Time Slot</h5>
                                    <div class="row">
                                        @php
                                            $timeSlots = [
                                                'Morning (6 AM - 12 PM)' => ['06:00', '12:00'],
                                                'Afternoon (12 PM - 4 PM)' => ['12:00', '16:00'],
                                                'Evening (4 PM - 8 PM)' => ['16:00', '20:00'],
                                                'Night (8 PM - 12 AM)' => ['20:00', '24:00'],
                                            ];
                                        @endphp
                                        @foreach($timeSlots as $label => $range)
                                            @php
                                                $count = $bookings->filter(function($booking) use ($range) {
                                                    $time = \Carbon\Carbon::parse($booking->time);
                                                    return $time->between(
                                                        \Carbon\Carbon::parse($range[0]), 
                                                        \Carbon\Carbon::parse($range[1])
                                                    );
                                                })->count();
                                            @endphp
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="card border-start border-primary border-3 shadow-sm h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="text-muted mb-1">{{ $label }}</h6>
                                                                <h4 class="mb-0">{{ $count }}</h4>
                                                            </div>
                                                            <div class="icon-shape icon-sm bg-primary-light rounded-3">
                                                                <i class="bi bi-clock text-primary"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Time</th>
                                    <th>Customer</th>
                                    <th>Guests</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong>{{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</strong>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title bg-light rounded-circle">
                                                        <i class="bi bi-person fs-4"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $booking->name }}</h6>
                                                    <small class="text-muted">#{{ $booking->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-people me-1"></i>{{ $booking->guests ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="tel:{{ $booking->phone }}" 
                                                   class="text-decoration-none">
                                                    <i class="bi bi-telephone me-1"></i>{{ $booking->phone }}
                                                </a>
                                                @if($booking->email)
                                                    <small>
                                                        <a href="mailto:{{ $booking->email }}" 
                                                           class="text-decoration-none">
                                                            {{ $booking->email }}
                                                        </a>
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-status-{{ str_replace('_', '-', $booking->status) }}">
                                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->note)
                                                <small>{{ Str::limit($booking->note, 50) }}</small>
                                            @else
                                                <span class="text-muted">No notes</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if($booking->status == 'pending')
                                                    <form action="{{ route('admin.bookings.update-status', $booking->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="btn btn-sm btn-success" title="Confirm">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                                    <form action="{{ route('admin.bookings.update-status', $booking->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Cancel">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="bi bi-calendar-x display-1 text-muted"></i>
                                                <h4 class="mt-3">No bookings for today</h4>
                                                <p class="text-muted">There are no bookings scheduled for today.</p>
                                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary mt-2">
                                                    View All Bookings
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Booking Summary -->
                    @if($bookings->count() > 0)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Today's Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape icon-lg bg-primary-light rounded-3 me-3">
                                                        <i class="bi bi-people text-primary fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-muted mb-1">Total Guests</h6>
                                                        <h3 class="mb-0">{{ $bookings->sum('guests') }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape icon-lg bg-success-light rounded-3 me-3">
                                                        <i class="bi bi-check-circle text-success fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-muted mb-1">Confirmed</h6>
                                                        <h3 class="mb-0">{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape icon-lg bg-warning-light rounded-3 me-3">
                                                        <i class="bi bi-clock text-warning fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-muted mb-1">Pending</h6>
                                                        <h3 class="mb-0">{{ $bookings->where('status', 'pending')->count() }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape icon-lg bg-info-light rounded-3 me-3">
                                                        <i class="bi bi-calendar-check text-info fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-muted mb-1">Total Bookings</h6>
                                                        <h3 class="mb-0">{{ $bookings->count() }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-status-pending { background-color: #ffc107; color: #000; }
    .badge-status-confirmed { background-color: #198754; color: #fff; }
    .badge-status-cancelled { background-color: #dc3545; color: #fff; }
    .badge-status-completed { background-color: #0dcaf0; color: #000; }
    .badge-status-no-show { background-color: #6c757d; color: #fff; }
    
    .avatar-sm {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem;
    }
    
    .icon-shape.icon-lg {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
</style>
@endpush