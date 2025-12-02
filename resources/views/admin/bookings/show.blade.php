@extends('admin.layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Booking Details - #{{ $booking->id }}</h4>
                            <small class="text-muted">Created: {{ $booking->created_at->format('M d, Y h:i A') }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>
                            @if($booking->status == 'pending')
                                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle me-1"></i> Confirm
                                    </button>
                                </form>
                            @endif
                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        <i class="bi bi-x-circle me-1"></i> Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column - Booking Details -->
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Booking Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Booking ID</label>
                                            <p class="fw-bold">#{{ $booking->id }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Status</label>
                                            <div>
                                                <span class="badge badge-status-{{ str_replace('_', '-', $booking->status) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Booking Date</label>
                                            <p class="fw-bold">{{ \Carbon\Carbon::parse($booking->date)->format('F d, Y') }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Booking Time</label>
                                            <p class="fw-bold">{{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Number of Guests</label>
                                            <p class="fw-bold">{{ $booking->guests ?? 'Not specified' }}</p>
                                        </div>
                                        @if($booking->note)
                                            <div class="col-12 mb-3">
                                                <label class="form-label text-muted">Customer Notes</label>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-0">{{ $booking->note }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Customer Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Name</label>
                                            <p class="fw-bold">{{ $booking->name }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Phone</label>
                                            <p class="fw-bold">
                                                <a href="tel:{{ $booking->phone }}" class="text-decoration-none">
                                                    {{ $booking->phone }}
                                                </a>
                                            </p>
                                        </div>
                                        @if($booking->email)
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted">Email</label>
                                                <p class="fw-bold">
                                                    <a href="mailto:{{ $booking->email }}" class="text-decoration-none">
                                                        {{ $booking->email }}
                                                    </a>
                                                </p>
                                            </div>
                                        @endif
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Created At</label>
                                            <p class="fw-bold">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        @if($booking->updated_at != $booking->created_at)
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted">Last Updated</label>
                                                <p class="fw-bold">{{ $booking->updated_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                        @endif
                                        @if($booking->updated_by)
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted">Updated By</label>
                                                <p class="fw-bold">User #{{ $booking->updated_by }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Status History (if available) -->
                            @if($booking->status_histories && $booking->status_histories->count() > 0)
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Status History</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline">
                                            @foreach($booking->status_histories as $history)
                                                <div class="timeline-item">
                                                    <div class="timeline-marker"></div>
                                                    <div class="timeline-content">
                                                        <div class="d-flex justify-content-between">
                                                            <strong>{{ ucfirst(str_replace('_', ' ', $history->status)) }}</strong>
                                                            <small class="text-muted">{{ $history->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                        @if($history->notes)
                                                            <p class="mb-0 mt-1">{{ $history->notes }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column - Actions & Notes -->
                        <div class="col-md-4">
                            <!-- Status Update -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Update Status</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Change Status</label>
                                            <select class="form-control" name="status" required>
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="no_show" {{ $booking->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Admin Notes (Optional)</label>
                                            <textarea class="form-control" name="admin_notes" rows="3" 
                                                      placeholder="Add notes about this status change...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            Update Status
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Admin Notes Update -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Update Admin Notes</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.bookings.update-notes', $booking->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <textarea class="form-control" name="admin_notes" 
                                                      rows="4" placeholder="Add internal notes here...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            Save Notes
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Current Admin Notes -->
                            @if($booking->admin_notes)
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Current Admin Notes</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $booking->admin_notes }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="tel:{{ $booking->phone }}" 
                                           class="btn btn-outline-primary">
                                            <i class="bi bi-telephone me-2"></i> Call Customer
                                        </a>
                                        @if($booking->email)
                                            <a href="mailto:{{ $booking->email }}" 
                                               class="btn btn-outline-info">
                                                <i class="bi bi-envelope me-2"></i> Email Customer
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" 
                                              method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger w-100" 
                                                    onclick="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                                                <i class="bi bi-trash me-2"></i> Delete Booking
                                            </button>
                                        </form>
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
    .badge-status-pending { background-color: #ffc107; color: #000; }
    .badge-status-confirmed { background-color: #198754; color: #fff; }
    .badge-status-cancelled { background-color: #dc3545; color: #fff; }
    .badge-status-completed { background-color: #0dcaf0; color: #000; }
    .badge-status-no-show { background-color: #6c757d; color: #fff; }
    
    .timeline {
        position: relative;
        padding-left: 20px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -20px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #0d6efd;
    }
    
    .timeline-content {
        padding-left: 10px;
    }
</style>
@endpush