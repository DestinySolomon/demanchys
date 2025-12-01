@extends('admin.layouts.app')

@section('title', 'Pending Delivery Man Applications')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0 text-gray-800">Pending Delivery Man Applications</h2>
                <a href="{{ route('admin.delivery.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Back to Active
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($pendingApplications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Serial</th>
                                <th>Applicant</th>
                                <th>Contact</th>
                                <th>Vehicle Info</th>
                                <th>Applied On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingApplications as $application)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($application->avatar)
                                            <img src="{{ asset('storage/' . $application->avatar) }}" width="40" height="40" style="object-fit: cover;">
                                        @else
                                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-2" style="width:40px; height:40px;">
                                                <i class="bi bi-person text-dark"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $application->name }}</strong>
                                            <div class="text-muted small text-capitalize">{{ $application->gender }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div><i class="bi bi-envelope me-1"></i> {{ $application->email }}</div>
                                        <div><i class="bi bi-phone me-1"></i> {{ $application->phone }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($application->vehicle_type)
                                        <div class="small">
                                            <strong>{{ $application->vehicle_type }}</strong>
                                            <div class="text-muted">{{ $application->vehicle_number }}</div>
                                        </div>
                                    @else
                                        <span class="text-muted">No vehicle info</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        {{ $application->created_at->format('M d, Y') }}
                                        <div class="text-muted">{{ $application->created_at->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#applicationModal{{ $application->id }}">
                                            <i class="bi bi-eye"></i> Review
                                        </button>
                                        <form action="{{ route('admin.delivery.approve', $application->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Approve this delivery man application?')">
                                                <i class="bi bi-check-lg"></i> Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $application->id }}">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </div>

                                    <!-- Application Details Modal -->
                                    <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Application Details - {{ $application->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Personal Information</h6>
                                                            <table class="table table-sm table-borderless">
                                                                <tr><th>Full Name:</th><td>{{ $application->name }}</td></tr>
                                                                <tr><th>Email:</th><td>{{ $application->email }}</td></tr>
                                                                <tr><th>Phone:</th><td>{{ $application->phone }}</td></tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Vehicle Information</h6>
                                                            <table class="table table-sm table-borderless">
                                                                <tr><th>Vehicle Type:</th><td>{{ $application->vehicle_type ?? 'Not provided' }}</td></tr>
                                                                <tr><th>Vehicle Number:</th><td>{{ $application->vehicle_number ?? 'Not provided' }}</td></tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.delivery.approve', $application->id) }}" method="POST" class="me-2">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i> Approve Application</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $application->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Application</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.delivery.reject', $application->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3"><label for="rejection_reason" class="form-label">Reason for Rejection</label><textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea></div>
                                                    </div>
                                                    <div class="modal-footer"><button type="submit" class="btn btn-danger"><i class="bi bi-x-lg me-1"></i> Reject Application</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-check-circle display-1 text-success mb-3"></i>
                    <h4 class="text-success">All Caught Up!</h4>
                    <p class="text-muted">There are no pending delivery man applications at the moment.</p>
                    <a href="{{ route('admin.delivery.index') }}" class="btn btn-primary"><i class="bi bi-list-ul me-2"></i> View Active Delivery Men</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
