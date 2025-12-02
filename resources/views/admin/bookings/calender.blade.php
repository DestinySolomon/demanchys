@extends('admin.layouts.app')

@section('title', 'Booking Calendar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-calendar-week me-2"></i>
                            Booking Calendar - {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                        </h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-list-ul me-1"></i> All Bookings
                            </a>
                            <a href="{{ route('admin.bookings.today') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-calendar-day me-1"></i> Today's Bookings
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-outline-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                                </button>
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header">Navigate to Month</h6>
                                    @for($m = 1; $m <= 12; $m++)
                                        <a class="dropdown-item" href="{{ route('admin.bookings.calendar', ['year' => $year, 'month' => $m]) }}">
                                            {{ \Carbon\Carbon::create($year, $m, 1)->format('F Y') }}
                                        </a>
                                    @endfor
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('admin.bookings.calendar', ['year' => $year - 1, 'month' => $month]) }}">
                                        Previous Year
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.bookings.calendar', ['year' => $year + 1, 'month' => $month]) }}">
                                        Next Year
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Month Navigation -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="mb-0">
                                                <a href="{{ route('admin.bookings.calendar', ['year' => $year, 'month' => $month - 1]) }}" 
                                                   class="text-decoration-none me-3">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                                {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                                                <a href="{{ route('admin.bookings.calendar', ['year' => $year, 'month' => $month + 1]) }}" 
                                                   class="text-decoration-none ms-3">
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-outline-secondary btn-sm">
                                                Current Month
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Days Header -->
                                    <div class="row mb-3 text-center">
                                        <div class="col day-header">Sun</div>
                                        <div class="col day-header">Mon</div>
                                        <div class="col day-header">Tue</div>
                                        <div class="col day-header">Wed</div>
                                        <div class="col day-header">Thu</div>
                                        <div class="col day-header">Fri</div>
                                        <div class="col day-header">Sat</div>
                                    </div>

                                    <!-- Calendar Grid -->
                                    @php
                                        $firstDayOfMonth = \Carbon\Carbon::create($year, $month, 1);
                                        $daysInMonth = $firstDayOfMonth->daysInMonth;
                                        $firstDayOfWeek = $firstDayOfMonth->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
                                        
                                        // Start calendar from Sunday
                                        $currentDay = 1 - $firstDayOfWeek;
                                        
                                        $today = \Carbon\Carbon::today();
                                    @endphp

                                    @for($week = 0; $week < 6; $week++)
                                        <div class="row">
                                            @for($day = 0; $day < 7; $day++)
                                                @php
                                                    $currentDate = $firstDayOfMonth->copy()->addDays($currentDay);
                                                    $isCurrentMonth = $currentDate->month == $month;
                                                    $isToday = $currentDate->isSameDay($today);
                                                    
                                                    // Get bookings for this day
                                                    $dayBookings = $bookings->filter(function($booking) use ($currentDate) {
                                                        return \Carbon\Carbon::parse($booking->date)->isSameDay($currentDate);
                                                    });
                                                @endphp
                                                
                                                <div class="col calendar-day {{ !$isCurrentMonth ? 'other-month' : '' }} {{ $isToday ? 'today' : '' }}">
                                                    <div class="day-number">
                                                        {{ $currentDate->day }}
                                                    </div>
                                                    
                                                    @if($isCurrentMonth && $dayBookings->count() > 0)
                                                        @foreach($dayBookings->take(3) as $booking)
                                                            @php
                                                                $badgeClass = 'bg-primary';
                                                                $statusClass = '';
                                                                if ($booking->status == 'pending') {
                                                                    $statusClass = 'border-warning border-2';
                                                                } elseif ($booking->status == 'confirmed') {
                                                                    $statusClass = 'border-success border-2';
                                                                } elseif ($booking->status == 'cancelled') {
                                                                    $statusClass = 'border-danger border-2';
                                                                }
                                                            @endphp
                                                            
                                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                                               class="booking-badge {{ $badgeClass }} {{ $statusClass }} d-block text-white text-decoration-none"
                                                               title="{{ $booking->name }} - {{ $booking->guests }} guests - {{ ucfirst(str_replace('_', ' ', $booking->status)) }}">
                                                                {{ Str::limit($booking->name, 10) }} ({{ $booking->gugets ?? '?' }})
                                                            </a>
                                                        @endforeach
                                                        
                                                        @if($dayBookings->count() > 3)
                                                            <div class="booking-count text-muted">
                                                                +{{ $dayBookings->count() - 3 }} more
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                
                                                @php $currentDay++ @endphp
                                            @endfor
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-3">
                                    <h6 class="mb-3">Legend</h6>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">Booking</span>
                                            <small>Regular booking</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-warning border border-2 border-warning me-2"></span>
                                            <small>Pending</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success border border-2 border-success me-2"></span>
                                            <small>Confirmed</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-danger border border-2 border-danger me-2"></span>
                                            <small>Cancelled</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">●</span>
                                            <small>Today</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Monthly Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="card border-start border-primary border-3 shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="text-muted mb-1">Total Bookings</h6>
                                                            <h4 class="mb-0">{{ $bookings->count() }}</h4>
                                                        </div>
                                                        <div class="icon-shape icon-sm bg-primary-light rounded-3">
                                                            <i class="bi bi-calendar-check text-primary"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="card border-start border-success border-3 shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="text-muted mb-1">Confirmed</h6>
                                                            <h4 class="mb-0">{{ $bookings->where('status', 'confirmed')->count() }}</h4>
                                                        </div>
                                                        <div class="icon-shape icon-sm bg-success-light rounded-3">
                                                            <i class="bi bi-check-circle text-success"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="card border-start border-warning border-3 shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="text-muted mb-1">Pending</h6>
                                                            <h4 class="mb-0">{{ $bookings->where('status', 'pending')->count() }}</h4>
                                                        </div>
                                                        <div class="icon-shape icon-sm bg-warning-light rounded-3">
                                                            <i class="bi bi-clock text-warning"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="card border-start border-danger border-3 shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="text-muted mb-1">Cancelled</h6>
                                                            <h4 class="mb-0">{{ $bookings->where('status', 'cancelled')->count() }}</h4>
                                                        </div>
                                                        <div class="icon-shape icon-sm bg-danger-light rounded-3">
                                                            <i class="bi bi-x-circle text-danger"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .day-header {
        font-weight: bold;
        padding: 10px;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    
    .calendar-day {
        min-height: 150px;
        border: 1px solid #dee2e6;
        padding: 8px;
        position: relative;
        background-color: white;
    }
    
    .calendar-day.other-month {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    
    .calendar-day.today {
        background-color: #e7f1ff;
        border: 2px solid #0d6efd;
    }
    
    .day-number {
        font-weight: bold;
        margin-bottom: 5px;
        padding: 2px 6px;
        border-radius: 50%;
        display: inline-block;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 26px;
    }
    
    .calendar-day.today .day-number {
        background-color: #0d6efd;
        color: white;
    }
    
    .booking-badge {
        font-size: 0.75rem;
        margin-bottom: 3px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 3px 6px;
        border-radius: 4px;
    }
    
    .booking-count {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 5px;
    }
    
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
</style>
@endpush