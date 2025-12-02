@extends('admin.layouts.app')

@section('title', 'Promotional Banners')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-megaphone me-2"></i> Promotional Banners
                    </h5>
                    <a href="{{ route('admin.banners.promotional.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-lg me-1"></i> Add New
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($banners->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            <h5 class="mt-3">No Promotional Banners Yet</h5>
                            <p class="text-muted">Create your first promotional banner for the homepage</p>
                            <a href="{{ route('admin.banners.promotional.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i> Create Banner
                            </a>
                        </div>
                    @else
                        <div class="row">
                            @foreach($banners as $banner)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($banner->image_path) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $banner->title }}"
                                                 style="height: 200px; object-fit: cover;">
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $banner->title ?? 'Untitled Banner' }}</h6>
                                            @if($banner->description)
                                                <p class="card-text small text-muted">
                                                    {{ Str::limit($banner->description, 100) }}
                                                </p>
                                            @endif
                                            <p class="small text-muted mb-0">
                                                <i class="bi bi-sort-numeric-down"></i> Order: {{ $banner->order }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <div class="d-flex justify-content-between">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.banners.edit', $banner) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm {{ $banner->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                            <i class="bi {{ $banner->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Delete this promotional banner?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <span class="text-muted small">
                                                    {{ $banner->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <p class="text-muted small">
                                <i class="bi bi-info-circle me-1"></i>
                                Promotional banners appear on the homepage slider. Recommended size: 1200x400px
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
