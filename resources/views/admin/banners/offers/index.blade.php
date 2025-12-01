@extends('admin.layouts.app')

@section('title', 'Offer Deals')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-tag me-2"></i> Offer Deals
                    </h5>
                    <a href="{{ route('admin.banners.offers.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-lg me-1"></i> Add New Offer
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($offers->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-tag text-muted" style="font-size: 4rem;"></i>
                            <h5 class="mt-3">No Offer Deals Yet</h5>
                            <p class="text-muted">Create special offers and promotions for customers</p>
                            <a href="{{ route('admin.banners.offers.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-lg me-1"></i> Create Offer
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">Image</th>
                                        <th>Title & Description</th>
                                        <th width="150">Dates</th>
                                        <th width="100">Status</th>
                                        <th width="80">Order</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($offers as $offer)
                                        <tr>
                                            <td>
                                                <img src="{{ Storage::url($offer->image_path) }}" 
                                                     alt="{{ $offer->title }}"
                                                     class="img-thumbnail"
                                                     style="width: 70px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <strong>{{ $offer->title ?? 'Untitled Offer' }}</strong>
                                                @if($offer->description)
                                                    <p class="small text-muted mb-0 mt-1">
                                                        {{ Str::limit($offer->description, 100) }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if($offer->start_date || $offer->end_date)
                                                    <small>
                                                        @if($offer->start_date)
                                                            <div class="text-nowrap">{{ $offer->start_date->format('M d, Y') }}</div>
                                                        @endif
                                                        @if($offer->end_date)
                                                            <div class="text-nowrap">{{ $offer->end_date->format('M d, Y') }}</div>
                                                        @endif
                                                    </small>
                                                @else
                                                    <span class="text-muted small">No dates set</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $offer->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $offer->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $offer->order }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.banners.edit', $offer) }}" class="btn btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.banners.toggle', $offer) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn {{ $offer->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                            <i class="bi {{ $offer->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.banners.destroy', $offer) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this offer?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <p class="text-muted small">
                                <i class="bi bi-info-circle me-1"></i>
                                Offer deals appear in the special offers section. Recommended size: 600x400px
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('admin.layouts.app')

@section('title', 'Offer Deals')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-tag me-2"></i> Offer Deals
                    </h5>
                    <a href="{{ route('admin.banners.offers.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-lg me-1"></i> Add New Offer
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($offers->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-tag text-muted" style="font-size: 4rem;"></i>
                            <h5 class="mt-3">No Offer Deals Yet</h5>
                            <p class="text-muted">Create special offers and promotions for customers</p>
                            <a href="{{ route('admin.banners.offers.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-lg me-1"></i> Create Offer
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">Image</th>
                                        <th>Title & Description</th>
                                        <th width="150">Dates</th>
                                        <th width="100">Status</th>
                                        <th width="80">Order</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($offers as $offer)
                                        <tr>
                                            <td>
                                                <img src="{{ Storage::url($offer->image_path) }}" 
                                                     alt="{{ $offer->title }}"
                                                     class="img-thumbnail"
                                                     style="width: 70px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <strong>{{ $offer->title ?? 'Untitled Offer' }}</strong>
                                                @if($offer->description)
                                                    <p class="small text-muted mb-0 mt-1">
                                                        {{ Str::limit($offer->description, 100) }}
                                                    </p>
                                                @endif
                                                @if($offer->url)
                                                    <p class="small mb-0 mt-1">
                                                        <i class="bi bi-link-45deg"></i>
                                                        <a href="{{ $offer->url }}" target="_blank" class="text-decoration-none">
                                                            {{ Str::limit($offer->url, 30) }}
                                                        </a>
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if($offer->start_date || $offer->end_date)
                                                    <small>
                                                        @if($offer->start_date)
                                                            <div class="text-nowrap">
                                                                <i class="bi bi-calendar-plus"></i> 
                                                                {{ $offer->start_date->format('M d, Y') }}
                                                            </div>
                                                        @endif
                                                        @if($offer->end_date)
                                                            <div class="text-nowrap">
                                                                <i class="bi bi-calendar-minus"></i> 
                                                                {{ $offer->end_date->format('M d, Y') }}
                                                            </div>
                                                        @endif
                                                    </small>
                                                @else
                                                    <span class="text-muted small">No dates set</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $offer->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $offer->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $offer->order }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.banners.edit', $offer) }}" 
                                                       class="btn btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.banners.toggle', $offer) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn {{ $offer->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                                title="{{ $offer->is_active ? 'Deactivate' : 'Activate' }}">
                                                            <i class="bi {{ $offer->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.banners.destroy', $offer) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Delete this offer?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-muted small">
                                <i class="bi bi-info-circle me-1"></i>
                                Offer deals appear in the special offers section. Recommended size: 600x400px
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection