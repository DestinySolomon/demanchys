@extends('admin.layouts.app')

@section('title', 'Rejected Delivery Man Applications')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0 text-gray-800">Rejected Delivery Man Applications</h2>
                <a href="{{ route('admin.delivery.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Back to Active</a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($rejectedApplications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Serial</th>
                                <th>Applicant</th>
                                <th>Contact</th>
                                <th>Rejected On</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedApplications as $application)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($application->avatar)
                                            <img src="{{ asset('storage/' . $application->avatar) }}" alt="{{ $application->name }}" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:40px; height:40px;"><i class="bi bi-person text-light"></i></div>
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
                                    <div class="small">
                                        {{ $application->rejected_at->format('M d, Y') }}
                                        <div class="text-muted">{{ $application->rejected_at->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($application->rejection_reason)
                                        <span class="text-danger small">{{ Str::limit($application->rejection_reason, 50) }}</span>
                                    @else
                                        <span class="text-muted">No reason provided</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rejectedModal{{ $application->id }}"><i class="bi bi-eye"></i> Details</button>

                                    <!-- Rejected Application Details Modal -->
                                    <div class="modal fade" id="rejectedModal{{ $application->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Rejected Application - {{ $application->name }}</h5>
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
                                                            <h6>Rejection Details</h6>
                                                            <table class="table table-sm table-borderless">
                                                                <tr><th>Rejected On:</th><td>{{ $application->rejected_at->format('M d, Y h:i A') }}</td></tr>
                                                                <tr><th>Reason:</th><td class="text-danger">{{ $application->rejection_reason ?? 'No reason provided' }}</td></tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
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
                <div class="text-center py-5"><i class="bi bi-archive display-1 text-muted mb-3"></i><h4 class="text-muted">No Rejected Applications</h4><p class="text-muted">There are no rejected delivery man applications in the archive.</p></div>
            @endif
        </div>
    </div>
</div>
@endsection
