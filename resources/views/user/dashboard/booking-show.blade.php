@extends('layouts.user-dashboard-clean')

@section('title', 'Booking Details - Demanchys Lounge')

@section('content')
@php
    // Create proper datetime object
    $bookingDateTime = \Carbon\Carbon::parse($booking->date)->setTimeFromTimeString($booking->time);
    $canCancel = $bookingDateTime->isFuture() && in_array($booking->status, ['pending', 'confirmed']);
    $isUpcoming = $bookingDateTime->isFuture() && $booking->status == 'confirmed';
    $formattedDate = \Carbon\Carbon::parse($booking->date)->format('l, F j, Y');
    $formattedTime = \Carbon\Carbon::parse($booking->time)->format('h:i A');
    
    // For JavaScript - create ISO string for proper parsing
    $jsDateTime = $bookingDateTime->toISOString();
@endphp

<div class="container-fluid">
    <!-- Page Header -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-2">Booking Details</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.bookings') }}">My Bookings</a></li>
                        <li class="breadcrumb-item active">Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('user.bookings') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left me-1"></i> Back to Bookings
                </a>
                <button onclick="window.print()" class="btn btn-warning">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Booking Information -->
    <div class="row">
        <div class="col-lg-8">
            <div class="dashboard-card mb-4">
                <!-- Status and Basic Info -->
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h3 class="mb-1">{{ $booking->name }}</h3>
                        <p class="text-muted mb-0">Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                        @if($isUpcoming)
                            <small class="text-warning">
                                <i class="bi bi-clock me-1"></i>
                                {{ $bookingDateTime->diffForHumans() }}
                            </small>
                        @endif
                    </div>
                    <div class="text-end">
                        <span class="badge fs-6 px-3 py-2 bg-{{ 
                            $booking->status == 'confirmed' ? 'success' : 
                            ($booking->status == 'pending' ? 'warning' : 'secondary')
                        }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        @if($booking->status == 'confirmed')
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Confirmed
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Booking Details Grid -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="booking-detail-card">
                            <div class="d-flex align-items-center">
                                <div class="booking-icon me-3">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Date</h6>
                                    <p class="mb-0 text-muted">{{ $formattedDate }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="booking-detail-card">
                            <div class="d-flex align-items-center">
                                <div class="booking-icon me-3">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Time</h6>
                                    <p class="mb-0 text-muted">{{ $formattedTime }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="booking-detail-card">
                            <div class="d-flex align-items-center">
                                <div class="booking-icon me-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Number of Guests</h6>
                                    <p class="mb-0 text-muted">{{ $booking->guests }} guest(s)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="booking-detail-card">
                            <div class="d-flex align-items-center">
                                <div class="booking-icon me-3">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Phone Number</h6>
                                    <p class="mb-0 text-muted">{{ $booking->phone ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="booking-detail-card">
                            <div class="d-flex align-items-center">
                                <div class="booking-icon me-3">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Email Address</h6>
                                    <p class="mb-0 text-muted">{{ $booking->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="booking-detail-card">
                            <div class="d-flex align-items-center">
                                <div class="booking-icon me-3">
                                    <i class="bi bi-calendar-plus"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Booking Created</h6>
                                    <p class="mb-0 text-muted">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Special Requests -->
                @if($booking->note)
                <div class="booking-section">
                    <h5 class="mb-3">
                        <i class="bi bi-chat-left-text me-2"></i>
                        Special Requests / Notes
                    </h5>
                    <div class="booking-note-box">
                        {{ $booking->note }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Important Information -->
            <div class="dashboard-card">
                <h5 class="mb-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Important Information
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Check-in Procedure</h6>
                                <p class="small text-muted mb-0">
                                    Please arrive 15 minutes before your scheduled time. 
                                    Have your booking ID ready for verification.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-clock text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Cancellation Policy</h6>
                                <p class="small text-muted mb-0">
                                    Cancellations must be made at least 2 hours before the booking time. 
                                    Late cancellations may incur charges.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-person-check text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">ID Requirement</h6>
                                <p class="small text-muted mb-0">
                                    A valid government-issued ID is required for verification upon arrival.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-telephone text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Need Assistance?</h6>
                                <p class="small text-muted mb-0">
                                    Contact us at <strong>+234 8127743555</strong> for any questions or assistance.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Actions -->
        <div class="col-lg-4">
            <div class="dashboard-card mb-4">
                <h5 class="mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    @if($canCancel)
                        <button type="button" onclick="confirmCancellation()" 
                                class="btn btn-outline-danger btn-lg d-flex align-items-center justify-content-center">
                            <i class="bi bi-x-circle me-2"></i>
                            Cancel Booking
                        </button>
                    @endif

                    <button onclick="window.print()" 
                            class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center">
                        <i class="bi bi-printer me-2"></i>
                        Print Details
                    </button>

                    <a href="{{ route('reservation') }}" 
                       class="btn btn-warning btn-lg d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus-circle me-2"></i>
                        Make New Booking
                    </a>
                </div>
            </div>

            <!-- Booking Timeline -->
            <div class="dashboard-card mb-4">
                <h5 class="mb-3">Booking Timeline</h5>
                <div class="booking-timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">
                            {{ $booking->created_at->format('M d, Y') }}
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Booking Created</h6>
                            <p class="small text-muted mb-0">
                                {{ $booking->created_at->format('h:i A') }}
                            </p>
                            <p class="small text-muted mb-0">
                                Status: <span class="text-primary">Pending</span>
                            </p>
                        </div>
                    </div>

                    @if($booking->status == 'confirmed')
                    <div class="timeline-item">
                        <div class="timeline-date">
                            {{ $booking->updated_at->format('M d, Y') }}
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Booking Confirmed</h6>
                            <p class="small text-muted mb-0">
                                {{ $booking->updated_at->format('h:i A') }}
                            </p>
                            <p class="small text-muted mb-0">
                                Your booking has been confirmed
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($booking->status == 'cancelled')
                    <div class="timeline-item">
                        <div class="timeline-date">
                            {{ $booking->updated_at->format('M d, Y') }}
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Booking Cancelled</h6>
                            <p class="small text-muted mb-0">
                                {{ $booking->updated_at->format('h:i A') }}
                            </p>
                            @if($booking->updated_by)
                                <p class="small text-muted mb-0">
                                    By: {{ $booking->updated_by }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($isUpcoming)
                    <div class="timeline-item">
                        <div class="timeline-date">
                            {{ $formattedDate }}
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Scheduled Time</h6>
                            <p class="small text-muted mb-0">
                                {{ $formattedTime }}
                            </p>
                            <p class="small text-muted mb-0">
                                {{ $booking->guests }} guests
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Countdown Timer (for upcoming bookings) -->
            @if($isUpcoming)
            <div class="dashboard-card">
                <h5 class="mb-3">
                    <i class="bi bi-clock-history me-2"></i>
                    Countdown to Booking
                </h5>
                <div class="countdown-timer text-center">
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-days">00</div>
                        <div class="countdown-label">Days</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-hours">00</div>
                        <div class="countdown-label">Hours</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-minutes">00</div>
                        <div class="countdown-label">Minutes</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-seconds">00</div>
                        <div class="countdown-label">Seconds</div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">
                        Your booking is in {{ $bookingDateTime->diffForHumans() }}
                    </small>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Hidden form for cancellation -->
    <form method="POST" action="{{ route('user.bookings.cancel', $booking->id) }}" id="cancelForm" class="d-none">
        @csrf
        @method('PUT')
    </form>
</div>

@push('scripts')
<script>
    // Cancellation confirmation
    function confirmCancellation() {
        Swal.fire({
            title: 'Cancel Booking?',
            html: `Are you sure you want to cancel your booking for <strong>{{ $formattedDate }}</strong> at <strong>{{ $formattedTime }}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it',
            cancelButtonText: 'No, keep it',
            confirmButtonColor: '#dc3545',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancelForm').submit();
            }
        });
    }

    // Countdown timer for upcoming bookings - FIXED VERSION
    @if($isUpcoming)
    function updateCountdown() {
        // Use the ISO string we passed from PHP
        const bookingDate = new Date('{{ $jsDateTime }}').getTime();
        const now = new Date().getTime();
        const distance = bookingDate - now;

        if (distance < 0) {
            // Booking time has passed
            clearInterval(countdownInterval);
            document.getElementById('countdown-days').textContent = '00';
            document.getElementById('countdown-hours').textContent = '00';
            document.getElementById('countdown-minutes').textContent = '00';
            document.getElementById('countdown-seconds').textContent = '00';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
        document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
    }

    // Update countdown every second
    let countdownInterval = setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call
    @endif

    // Print styles
    const printStyle = document.createElement('style');
    printStyle.textContent = `
        @media print {
            .btn, .dashboard-card .row:first-child .col-auto,
            .booking-timeline, .countdown-timer, .dashboard-card:last-child {
                display: none !important;
            }
            
            .dashboard-card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                margin-bottom: 20px !important;
                page-break-inside: avoid;
            }
            
            .booking-detail-card {
                background: #f8f9fa !important;
            }
            
            .badge {
                border: 1px solid #000 !important;
            }
        }
    `;
    document.head.appendChild(printStyle);
</script>
@endpush

<style>
    .booking-detail-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s ease;
    }

    .booking-detail-card:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .booking-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #ffc107, #ff9800);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .booking-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .booking-note-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 1.5rem;
        border-radius: 8px;
        white-space: pre-line;
        line-height: 1.6;
    }

    .admin-note-box {
        background: #d1ecf1;
        border-left: 4px solid #0dcaf0;
        padding: 1.5rem;
        border-radius: 8px;
        white-space: pre-line;
        line-height: 1.6;
    }

    .booking-timeline {
        position: relative;
        padding-left: 30px;
    }

    .booking-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ffc107;
        border: 2px solid white;
        box-shadow: 0 0 0 3px #f8f9fa;
    }

    .timeline-date {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }

    /* Countdown timer styles */
    .countdown-timer {
        display: flex;
        justify-content: space-around;
        padding: 1rem 0;
    }

    .countdown-item {
        text-align: center;
    }

    .countdown-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffc107;
        background: #fff8e1;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 auto 0.5rem;
    }

    .countdown-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    @media (max-width: 768px) {
        .booking-detail-card {
            padding: 1rem;
        }
        
        .booking-icon {
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
        }
        
        .countdown-timer {
            padding: 0.5rem;
        }
        
        .countdown-value {
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
        }
    }

    /* Status badge colors */
    .bg-success { background-color: #198754 !important; }
    .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
    .bg-secondary { background-color: #6c757d !important; }
</style>
@endsection