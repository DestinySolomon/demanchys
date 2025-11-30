@extends('admin.layouts.app')

@section('title', 'Delivery Man Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0 text-gray-800">Delivery Man Management</h2>
                <div class="text-muted">
                    <i class="bi bi-info-circle me-1"></i> Delivery men register through the mobile app
                </div>
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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deliveryMen as $deliveryMan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($deliveryMan->avatar)
                                        <img src="{{ asset('storage/' . $deliveryMan->avatar) }}" 
                                             alt="{{ $deliveryMan->name }}" 
                                             class="rounded-circle me-2" 
                                             width="32" height="32" style="object-fit: cover;">
                                    @else
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 32px; height: 32px;">
                                            <i class="bi bi-person text-dark"></i>
                                        </div>
                                    @endif
                                    {{ $deliveryMan->name }}
                                </div>
                            </td>
                            <td>{{ $deliveryMan->email }}</td>
                            <td>{{ $deliveryMan->phone }}</td>
                            <td>
                                <span class="badge bg-info text-dark text-capitalize">{{ $deliveryMan->gender }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $deliveryMan->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($deliveryMan->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.delivery.show', $deliveryMan->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <form action="{{ route('admin.delivery.destroy', $deliveryMan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this delivery man?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-truck display-1 text-muted d-block mb-2"></i>
                                <h5 class="text-muted">No Delivery Men Registered Yet</h5>
                                <p class="text-muted mb-3">Delivery men will appear here once they register through the mobile application.</p>
                                <div class="text-muted small">
                                    <i class="bi bi-info-circle me-1"></i> 
                                    Delivery men register independently through the delivery app
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection