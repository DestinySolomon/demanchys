@extends('layouts.user-dashboard-clean')

@section('title', 'My Reviews - Demanchys Lounge')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="dashboard-card">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-2 text-muted">My Reviews</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Reviews</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Submit Review Form (Inline) -->
    @if($canSubmit)
    <div class="dashboard-card mb-4">
        <h4 class="mb-4 text-muted">Submit Your Review</h4>
        
        <form method="POST" action="{{ route('user.reviews.store') }}" id="testimonialForm" class="needs-validation" novalidate>
            @csrf
            
            <!-- Hidden input for rating value -->
            <input type="hidden" name="rating" id="ratingValue" value="{{ old('rating') }}" required>
            
            <div class="row">
                <!-- Star Rating -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2 fw-semibold text-muted">Your Rating *</label>
                    <div class="star-rating mb-3 text-warning" id="starRatingContainer">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">Click on a star to rate</small>
                            <div id="ratingText" class="text-warning fw-semibold mt-1">
                                @if(old('rating'))
                                    @php
                                        $ratingDescriptions = [
                                            1 => "Poor - Not satisfied",
                                            2 => "Fair - Could be better",
                                            3 => "Good - Met expectations",
                                            4 => "Very Good - Above expectations",
                                            5 => "Excellent - Outstanding experience"
                                        ];
                                    @endphp
                                    {{ $ratingDescriptions[old('rating')] ?? '' }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="ratingError">
                        Please select a rating
                    </div>
                </div>

                <!-- Designation -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="designation" class="form-label fw-semibold">Your Title/Role (Optional)</label>
                        <input type="text" class="form-control" id="designation" name="designation" 
                               value="{{ old('designation') }}"
                               placeholder="e.g., Regular Customer, Food Critic, etc.">
                        <div class="form-text">
                            Helps others understand your perspective
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Content -->
            <div class="mb-4">
                <div class="form-group">
                    <label for="content" class="form-label fw-semibold">Your Review *</label>
                    <textarea class="form-control" id="content" name="content" rows="5" 
                              placeholder="Share your experience with Demanchys Lounge. What did you like? What could be improved?"
                              required minlength="20" maxlength="1000">{{ old('content') }}</textarea>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="form-text">
                            Minimum 20 characters, maximum 1000 characters
                        </div>
                        <small class="text-muted">
                            <span id="charCount">0</span>/1000 characters
                        </small>
                    </div>
                    <div class="invalid-feedback">
                        Please write a review (minimum 20 characters)
                    </div>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="alert alert-info mb-4">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-2 fw-semibold">Review Guidelines</h6>
                        <ul class="mb-0 ps-3" style="font-size: 0.9rem;">
                            <li>Share your genuine experience with our food and service</li>
                            <li>Be respectful and constructive in your feedback</li>
                            <li>Focus on specific aspects you liked or would like to see improved</li>
                            <li>All reviews are moderated before approval</li>
                            <li>Approved reviews may be featured on our website</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-send me-2"></i> Submit Review
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- User's Testimonials -->
    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-muted">My Submitted Reviews</h4>
            <div class="text-muted">
                {{ $testimonials->count() }} review(s)
            </div>
        </div>

        @if($testimonials->count() > 0)
            <div class="row">
                @foreach($testimonials as $testimonial)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border h-100 shadow-sm">
                        <div class="card-body">
                            <!-- Testimonial Header -->
                            <div class="d-flex align-items-center mb-3">
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                         alt="{{ $testimonial->name }}"
                                         class="rounded-circle me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px;">
                                        <span class="text-dark fw-bold">{{ substr($testimonial->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $testimonial->name }}</h6>
                                    <p class="text-muted small mb-0">
                                        {{ $testimonial->designation }}
                                    </p>
                                </div>
                            </div>

                            <!-- Star Rating -->
                            <div class="mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-2 small text-muted">{{ $testimonial->rating }}.0</span>
                            </div>

                            <!-- Testimonial Content -->
                            <div class="mb-3">
                                <p class="mb-0">{{ $testimonial->content }}</p>
                            </div>

                            <!-- Footer -->
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    {{ $testimonial->created_at->format('M d, Y') }}
                                </small>
                                @if($testimonial->is_approved)
                                    @if($testimonial->is_featured)
                                        <span class="badge bg-success">Featured</span>
                                    @else
                                        <span class="badge bg-primary">Approved</span>
                                    @endif
                                @else
                                    <span class="badge bg-warning">Pending Review</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- No Reviews Yet -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-chat-square-text fs-1 text-muted"></i>
                </div>
                <h4 class="text-muted mb-3">No Reviews Yet</h4>
                <p class="text-muted mb-4">Share your experience with Demanchys Lounge to help others.</p>
                
                @if(!$canSubmit)
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        You already have a review pending approval or approved.
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Featured Testimonials (from other users) -->
    @php
        $featuredTestimonials = \App\Models\Testimonial::where('is_featured', true)
                                                      ->where('is_approved', true)
                                                      ->where(function($query) {
                                                          $query->where('user_id', '!=', Auth::id())
                                                                ->orWhereNull('user_id');
                                                      })
                                                      ->take(3)
                                                      ->get();
    @endphp
    
    @if($featuredTestimonials->count() > 0)
    <div class="dashboard-card mt-4">
        <h4 class="mb-3 text-muted">
            <i class="bi bi-stars text-warning me-2"></i>
            Featured Reviews from Our Customers
        </h4>
        <div class="row">
            @foreach($featuredTestimonials as $testimonial)
            <div class="col-md-4 mb-3">
                <div class="card border h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                     alt="{{ $testimonial->name }}"
                                     class="rounded-circle me-3"
                                     style="width: 45px; height: 45px; object-fit: cover;">
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $testimonial->name }}</h6>
                                <p class="text-muted small mb-0">{{ $testimonial->designation }}</p>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        
                        <p class="small mb-0">{{ Str::limit($testimonial->content, 120) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    /* Star Rating Styles - CORRECT Version */
    .star-rating .stars {
        display: flex;
        gap: 8px;
    }
    
    .star-rating .star {
        cursor: pointer;
        font-size: 2.5rem;
        color: #ddd; /* Empty star color */
        transition: all 0.2s ease;
    }
    
    .star-rating .star:hover {
        transform: scale(1.1);
    }
    
    /* When a star is selected, it and all previous stars should be filled */
    .star-rating .star.selected,
    .star-rating .star.selected ~ .star {
        color: #ffc107; /* Filled star color */
    }
    
    /* Hover preview - show stars as filled on hover */
    .star-rating .star:hover,
    .star-rating .star:hover ~ .star {
        color: rgba(255, 193, 7, 0.7);
    }
    
    /* Remove hover effect from stars after the hovered one */
    .star-rating .star:hover ~ .star {
        color: #ddd;
    }
    
    /* Fix the hover chain logic */
    .stars:hover .star {
        color: rgba(255, 193, 7, 0.7);
    }
    
    .stars .star:hover ~ .star {
        color: #ddd;
    }
    
    /* When stars are selected, override hover colors */
    .stars .star.selected,
    .stars .star.selected ~ .star {
        color: #ffc107 !important;
    }
    
    /* Validation error state */
    .star-rating.is-invalid {
        border: 1px solid #dc3545;
        border-radius: 8px;
        padding: 10px;
        background-color: rgba(220, 53, 69, 0.05);
    }
    
    /* Rating text */
    #ratingText {
        margin-top: 5px;
        font-size: 0.9rem;
        min-height: 20px;
    }
    
    /* Mobile responsive stars */
    @media (max-width: 768px) {
        .star-rating .star {
            font-size: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Star rating functionality
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingValueInput = document.getElementById('ratingValue');
        const ratingText = document.getElementById('ratingText');
        const starRatingContainer = document.getElementById('starRatingContainer');
        
        // Rating descriptions
        const ratingDescriptions = {
            1: "Poor - Not satisfied",
            2: "Fair - Could be better", 
            3: "Good - Met expectations",
            4: "Very Good - Above expectations",
            5: "Excellent - Outstanding experience"
        };
        
        // Set initial rating from old input if exists
        const oldRating = {{ old('rating') ?? 0 }};
        if (oldRating > 0) {
            setRating(oldRating);
        }
        
        // Function to set rating - fills selected star and all previous ones
        function setRating(rating) {
            // Update all stars
            stars.forEach((star, index) => {
                const starNumber = index + 1;
                
                if (starNumber <= rating) {
                    // This star should be filled
                    star.classList.add('selected');
                    star.classList.remove('bi-star');
                    star.classList.add('bi-star-fill');
                } else {
                    // This star should be empty
                    star.classList.remove('selected');
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                }
            });
            
            // Update hidden input
            ratingValueInput.value = rating;
            
            // Update rating text
            ratingText.textContent = ratingDescriptions[rating];
            
            // Remove error state
            starRatingContainer.classList.remove('is-invalid');
        }
        
        // Add click events to stars
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = index + 1;
                setRating(rating);
            });
            
            // Add hover effects for preview
            star.addEventListener('mouseenter', function() {
                const hoverRating = index + 1;
                
                // Preview hover state - fill stars up to hovered one
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('bi-star-fill');
                        s.classList.remove('bi-star');
                    } else {
                        s.classList.remove('bi-star-fill');
                        s.classList.add('bi-star');
                    }
                });
                
                // Show hover text
                ratingText.textContent = ratingDescriptions[hoverRating] + " (Click to select)";
            });
            
            star.addEventListener('mouseleave', function() {
                // Restore to actual selected state
                const currentRating = parseInt(ratingValueInput.value);
                if (currentRating > 0) {
                    setRating(currentRating);
                } else {
                    // No rating selected, show all empty
                    stars.forEach(s => {
                        s.classList.remove('bi-star-fill');
                        s.classList.add('bi-star');
                        s.classList.remove('selected');
                    });
                    ratingText.textContent = '';
                }
            });
        });
        
        // Character counter
        const contentTextarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');
        
        if (contentTextarea && charCount) {
            // Update count on page load
            charCount.textContent = contentTextarea.value.length;
            
            // Update count on input
            contentTextarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
                
                // Add warning class if close to limit
                if (this.value.length > 950) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                }
            });
        }
        
        // Form validation
        const form = document.getElementById('testimonialForm');
        if (form) {
            form.addEventListener('submit', function(event) {
                // Check if rating is selected
                const ratingSelected = parseInt(ratingValueInput.value);
                if (!ratingSelected || ratingSelected < 1 || ratingSelected > 5) {
                    starRatingContainer.classList.add('is-invalid');
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
                
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
                
                form.classList.add('was-validated');
            }, false);
        }
        
        // Display any validation errors from server
        @if($errors->any())
            // Add was-validated class to show server errors
            if (form) {
                form.classList.add('was-validated');
            }
            
            // Highlight rating error if exists
            @if($errors->has('rating'))
                starRatingContainer.classList.add('is-invalid');
            @endif
            
            // Show toast notification for errors
            const errorMessages = @json($errors->all());
            if (errorMessages.length > 0) {
                setTimeout(() => {
                    Swal.fire({
                        title: 'Please fix the errors',
                        html: '<ul class="text-start">' + 
                              errorMessages.map(msg => `<li>${msg}</li>`).join('') + 
                              '</ul>',
                        icon: 'error',
                        confirmButtonColor: '#ffc107'
                    });
                }, 500);
            }
        @endif
        
        // Display success message if exists
        @if(session('success'))
            setTimeout(() => {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#ffc107',
                    timer: 3000,
                    showConfirmButton: false
                });
                
                // Clear form if success
                if (form && '{{ session('success') }}'.includes('submitted')) {
                    setTimeout(() => {
                        form.reset();
                        ratingValueInput.value = '';
                        ratingText.textContent = '';
                        charCount.textContent = "0";
                        form.classList.remove('was-validated');
                        starRatingContainer.classList.remove('is-invalid');
                        
                        // Reset stars to empty
                        stars.forEach(star => {
                            star.classList.remove('selected', 'bi-star-fill');
                            star.classList.add('bi-star');
                        });
                    }, 1000);
                }
            }, 500);
        @endif
        
        @if(session('error'))
            setTimeout(() => {
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#ffc107'
                });
            }, 500);
        @endif
    });
</script>
@endpush
@endsection