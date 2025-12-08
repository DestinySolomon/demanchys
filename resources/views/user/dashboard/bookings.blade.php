@extends('layouts.user-dashboard-clean')

@section('title', 'My Bookings - Demanchys Lounge')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-2 text-muted">My Bookings</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Bookings</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('reservation') }}" class="btn btn-warning">
                    <i class="bi bi-plus-circle me-1"></i> New Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Booking Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(13, 110, 253, 0.1);">
                        <i class="bi bi-calendar-check fs-4" style="color: #0d6efd;"></i>
                    </div>
                </div>
                <h4 class="mb-1 text-muted">{{ $bookingStats['total'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Total Bookings</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-calendar-week fs-4" style="color: #ffc107;"></i>
                    </div>
                </div>
                <h4 class="mb-1 text-muted">{{ $bookingStats['upcoming'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Upcoming</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(25, 135, 84, 0.1);">
                        <i class="bi bi-check-circle fs-4" style="color: #198754;"></i>
                    </div>
                </div>
                <h4 class="mb-1 text-muted">{{ $bookingStats['confirmed'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Confirmed</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card h-100 text-center">
                <div class="mb-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(108, 117, 125, 0.1);">
                        <i class="bi bi-clock-history fs-4" style="color: #6c757d;"></i>
                    </div>
                </div>
                <h4 class="mb-1 text-muted">{{ $bookingStats['pending'] ?? 0 }}</h4>
                <p class="text-muted mb-0">Pending</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="dashboard-card mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="statusFilter" class="form-label fw-medium">Filter by Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="all">All Bookings</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="dateFilter" class="form-label fw-medium">Filter by Date</label>
                <select class="form-select" id="dateFilter">
                    <option value="all">All Dates</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="past">Past</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="searchBookings" class="form-label fw-medium">Search Bookings</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchBookings" placeholder="Search by name, event...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings List -->
    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Booking History</h4>
            <div class="text-muted">
                {{ $bookings->total() }} booking(s) found
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="row">
                @foreach($bookings as $booking)
                <div class="col-md-6 col-lg-4 mb-4 booking-card" 
                     data-status="{{ $booking->status }}"
                     data-date="{{ $booking->date }}">
                    <div class="card border h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $booking->name }}</h5>
                                    <p class="text-muted small mb-0">{{ $booking->email }}</p>
                                </div>
                                <span class="badge booking-status-badge bg-{{ 
                                    $booking->status == 'confirmed' ? 'success' : 
                                    ($booking->status == 'pending' ? 'warning' : 'secondary')
                                }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            
                            <div class="booking-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($booking->date)->format('D, M d, Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-clock text-primary me-2"></i>
                                    <span>{{ $booking->time }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-people text-primary me-2"></i>
                                    <span>{{ $booking->guests }} guest(s)</span>
                                </div>
                            </div>
                            
                            @if($booking->note)
                            <div class="booking-note mb-3">
                                <small class="text-muted">Note:</small>
                                <p class="small mb-0">{{ Str::limit($booking->note, 80) }}</p>
                            </div>
                            @endif
                            
                            <div class="booking-actions d-flex gap-2">
                                <a href="{{ route('user.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="bi bi-eye me-1"></i> Details
                                </a>
                                
                                @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                    @php
                                        $bookingDT = \Carbon\Carbon::parse($booking->date)->setTimeFromTimeString($booking->time);
                                    @endphp
                                    @if($bookingDT->isFuture())
                                        <form method="POST" action="{{ route('user.bookings.cancel', $booking->id) }}" 
                                              onsubmit="return confirm('Are you sure you want to cancel this booking?');"
                                              class="d-inline flex-fill">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                <i class="bi bi-x-circle me-1"></i> Cancel
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="text-muted small mt-3">
                                <i class="bi bi-clock-history me-1"></i>
                                Booked {{ $booking->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($bookings->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }}
                </div>
                <nav aria-label="Booking pagination">
                    <ul class="pagination mb-0">
                        {{-- Previous Page Link --}}
                        @if($bookings->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $bookings->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach(range(1, $bookings->lastPage()) as $page)
                            @if($page == $bookings->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @elseif($page >= $bookings->currentPage() - 2 && $page <= $bookings->currentPage() + 2)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bookings->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if($bookings->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $bookings->nextPageUrl() }}" rel="next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        @else
            <!-- No Bookings -->
            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Bookings Yet</h4>
                <p class="text-muted mb-4">You haven't made any bookings yet.</p>
                <a href="{{ route('reservation') }}" class="btn btn-warning">
                    <i class="bi bi-calendar-plus me-1"></i> Make a Reservation
                </a>
            </div>
        @endif
    </div>

    <!-- Upcoming Bookings (if any) -->
    @php
        $upcomingBookings = $bookings->filter(function($booking) {
            $dt = \Carbon\Carbon::parse($booking->date)->setTimeFromTimeString($booking->time);
            return $booking->status == 'confirmed' && $dt->isFuture();
        });
    @endphp
    
    @if($upcomingBookings->count() > 0)
    <div class="dashboard-card mt-4">
        <h4 class="mb-3">
            <i class="bi bi-calendar2-check text-warning me-2"></i>
            Upcoming Bookings
        </h4>
        
        <div class="row">
            @foreach($upcomingBookings->take(3) as $booking)
            <div class="col-md-4 mb-3">
                <div class="card border border-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h6 class="card-title mb-0">{{ $booking->name }}</h6>
                            <span class="badge bg-warning text-dark">Upcoming</span>
                        </div>
                        <p class="card-text small text-muted mb-2">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}
                        </p>
                        <p class="card-text small text-muted mb-2">
                            <i class="bi bi-clock me-1"></i>
                            {{ $booking->time }}
                        </p>
                        <p class="card-text small text-muted mb-3">
                            <i class="bi bi-people me-1"></i>
                            {{ $booking->guests }} guests
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('user.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-warning">
                                View Details
                            </a>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($booking->date)->setTimeFromTimeString($booking->time)->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($upcomingBookings->count() > 3)
        <div class="text-center mt-3">
            <a href="{{ route('user.bookings') }}?filter=upcoming" class="btn btn-sm btn-outline-primary">
                View All Upcoming ({{ $upcomingBookings->count() }})
            </a>
        </div>
        @endif
    </div>
    @endif

    <!-- Booking Tips -->
    <div class="dashboard-card mt-4">
        <h5 class="mb-3">
            <i class="bi bi-info-circle text-primary me-2"></i>
            Booking Information
        </h5>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-clock-history fs-4 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Modification Policy</h6>
                        <p class="small text-muted mb-0">You can modify or cancel bookings up to 2 hours before the scheduled time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-people fs-4 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Group Bookings</h6>
                        <p class="small text-muted mb-0">For groups larger than 10, please contact us directly for special arrangements.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-telephone fs-4 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Need Help?</h6>
                        <p class="small text-muted mb-0">Contact us at <strong>{{ $settings['site_phone'] ?? '+234 8127743555' }}</strong> for assistance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const searchInput = document.getElementById('searchBookings');
        const bookingCards = document.querySelectorAll('.booking-card');

        function filterBookings() {
            const status = statusFilter.value;
            const dateFilterValue = dateFilter.value;
            const searchTerm = searchInput.value.toLowerCase();
            const today = new Date().toISOString().split('T')[0];
            
            bookingCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                const cardDate = card.getAttribute('data-date');
                const cardText = card.textContent.toLowerCase();
                
                // Status filter
                const statusMatch = status === 'all' || cardStatus === status;
                
                // Date filter
                let dateMatch = true;
                if (dateFilterValue !== 'all') {
                    const bookingDate = new Date(cardDate);
                    const now = new Date();
                    
                    switch(dateFilterValue) {
                        case 'upcoming':
                            dateMatch = bookingDate >= now;
                            break;
                        case 'past':
                            dateMatch = bookingDate < now;
                            break;
                        case 'today':
                            dateMatch = cardDate === today;
                            break;
                        case 'week':
                            const weekFromNow = new Date();
                            weekFromNow.setDate(now.getDate() + 7);
                            dateMatch = bookingDate >= now && bookingDate <= weekFromNow;
                            break;
                        case 'month':
                            const monthFromNow = new Date();
                            monthFromNow.setMonth(now.getMonth() + 1);
                            dateMatch = bookingDate >= now && bookingDate <= monthFromNow;
                            break;
                    }
                }
                
                // Search filter
                const searchMatch = !searchTerm || cardText.includes(searchTerm);
                
                // Show/hide card
                card.style.display = (statusMatch && dateMatch && searchMatch) ? '' : 'none';
            });
        }

        if (statusFilter) statusFilter.addEventListener('change', filterBookings);
        if (searchInput) searchInput.addEventListener('input', filterBookings);
        if (dateFilter) dateFilter.addEventListener('change', filterBookings);

        // Initialize filters if URL has parameters
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        const filterParam = urlParams.get('filter');
        
        if (statusParam && statusFilter) {
            statusFilter.value = statusParam;
        }
        
        if (filterParam && dateFilter) {
            dateFilter.value = filterParam;
        }
        
        // Apply initial filters
        filterBookings();
    });
</script>
@endpush

<style>
    .booking-card .card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .booking-card .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .booking-status-badge {
        font-size: 0.7rem;
        padding: 0.25em 0.75em;
        border-radius: 20px;
    }
    
    .booking-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .booking-note {
        background: #fff3cd;
        border-left: 3px solid #ffc107;
        padding: 0.75rem;
        border-radius: 4px;
    }
    
    .booking-actions .btn {
        border-radius: 6px;
        padding: 0.375rem 0.75rem;
    }
    
    .page-link {
        color: #495057;
        border-color: #dee2e6;
    }
    
    .page-link:hover {
        color: #000;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .page-item.active .page-link {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #000;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
    
    .card.border-warning {
        border-color: #ffc107 !important;
        border-width: 2px;
    }
</style>
@endsection