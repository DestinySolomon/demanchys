@extends('admin.layouts.app')

@section('title', 'Gallery Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0 text-gray-800">Gallery Management</h2>
                <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i> Add New Image
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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($images as $image)
                        <tr>
                            <td>{{ $image->id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $image->title }}" 
                                     style="width: 60px; height: 60px; object-fit: cover;" 
                                     class="rounded border">
                            </td>
                            <td>{{ $image->title }}</td>
                            <td>
                                @if($image->description)
                                    {{ Str::limit($image->description, 50) }}
                                @else
                                    <span class="text-muted">No description</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $image->category_display_name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.gallery.edit', $image->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-images display-1 text-muted d-block mb-2"></i>
                                <h5 class="text-muted">No gallery images found</h5>
                                <p class="text-muted mb-3">Get started by adding your first image to the gallery.</p>
                                <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i> Add First Image
                                </a>
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