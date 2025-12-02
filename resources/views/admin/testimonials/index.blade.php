@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">⭐ Testimonials</h1>
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Testimonial
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Total</h6>
                            <h4 class="mb-0">{{ $totalCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-chat-quote fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Featured</h6>
                            <h4 class="mb-0">{{ $featuredCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-star fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Approved</h6>
                            <h4 class="mb-0">{{ $approvedCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Pending</h6>
                            <h4 class="mb-0">{{ $pendingCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-clock fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-body py-3">
            <form action="{{ route('admin.testimonials.index') }}" method="GET" class="row g-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="search" 
                               placeholder="Search testimonials..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Testimonials</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Testimonials Table -->
    <div class="card shadow">
        <div class="card-body p-0">
            @if($testimonials->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" width="80">Image</th>
                            <th>Customer & Review</th>
                            <th width="120">Rating</th>
                            <th width="120">Status</th>
                            <th width="100">Order</th>
                            <th class="text-end pe-3" width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortableTestimonials">
                        @foreach($testimonials as $testimonial)
                        <tr data-id="{{ $testimonial->id }}">
                            <td class="ps-3">
                                @if($testimonial->image)
                                <img src="{{ Storage::url($testimonial->image) }}" 
                                     alt="{{ $testimonial->name }}"
                                     class="rounded-circle"
                                     style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $testimonial->name }}</div>
                                @if($testimonial->designation)
                                <small class="text-muted">{{ $testimonial->designation }}</small>
                                @endif
                                <div class="mt-1 small text-truncate" style="max-width: 300px;">
                                    {{ Str::limit($testimonial->content, 100) }}
                                </div>
                            </td>
                            <td>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted">{{ $testimonial->rating }}/5</small>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge {{ $testimonial->is_featured ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $testimonial->is_featured ? 'Featured' : 'Normal' }}
                                    </span>
                                    <span class="badge {{ $testimonial->is_approved ? 'bg-info' : 'bg-warning' }}">
                                        {{ $testimonial->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-dark">{{ $testimonial->order }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.testimonials.toggle-featured', $testimonial) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn {{ $testimonial->is_featured ? 'btn-success' : 'btn-outline-success' }}"
                                                title="{{ $testimonial->is_featured ? 'Remove Featured' : 'Mark as Featured' }}">
                                            <i class="bi bi-star"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.testimonials.toggle-approved', $testimonial) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn {{ $testimonial->is_approved ? 'btn-info' : 'btn-outline-info' }}"
                                                title="{{ $testimonial->is_approved ? 'Unapprove' : 'Approve' }}">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this testimonial?')">
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
            
            <!-- Pagination -->
            <div class="p-3 border-top">
                {{ $testimonials->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-chat-quote fs-1 text-muted"></i>
                <h5 class="mt-3">No Testimonials Found</h5>
                <p class="text-muted">
                    @if(request('search') || request('status'))
                    Try changing your search criteria
                    @else
                    No testimonials yet. Add your first one!
                    @endif
                </p>
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-lg me-1"></i> Add First Testimonial
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .sortable-handle {
        cursor: move;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Initialize sortable
    new Sortable(document.getElementById('sortableTestimonials'), {
        handle: '.sortable-handle',
        animation: 150,
        onEnd: function(evt) {
            const items = Array.from(evt.from.children);
            const orders = items.map((item, index) => ({
                id: item.dataset.id,
                order: index + 1
            }));
            
            // Send AJAX request to update order
            fetch('{{ route("admin.testimonials.update-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    testimonials: orders
                })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      // Update order numbers in table
                      items.forEach((item, index) => {
                          const badge = item.querySelector('.badge.bg-dark');
                          if (badge) {
                              badge.textContent = index + 1;
                          }
                      });
                      
                      // Show success message
                      alert('Order updated successfully!');
                  }
              });
        }
    });
</script>
@endpush
@endsection