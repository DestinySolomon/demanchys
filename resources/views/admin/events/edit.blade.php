@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Event</h1>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Events
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Event Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Event Title -->
                    <div class="col-md-8 mb-3">
                        <label for="title" class="form-label">Event Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $event->title) }}" 
                               required maxlength="255">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Event Type -->
                    <div class="col-md-4 mb-3">
                        <label for="event_type" class="form-label">Event Type *</label>
                        <select class="form-control @error('event_type') is-invalid @enderror" 
                                id="event_type" name="event_type" required>
                            <option value="">Select Type</option>
                            <option value="party" {{ old('event_type', $event->event_type) == 'party' ? 'selected' : '' }}>🎉 Party</option>
                            <option value="corporate" {{ old('event_type', $event->event_type) == 'corporate' ? 'selected' : '' }}>💼 Corporate Event</option>
                            <option value="special_dinner" {{ old('event_type', $event->event_type) == 'special_dinner' ? 'selected' : '' }}>🍽️ Special Dinner</option>
                            <option value="live_music" {{ old('event_type', $event->event_type) == 'live_music' ? 'selected' : '' }}>🎭 Live Music</option>
                            <option value="wine_tasting" {{ old('event_type', $event->event_type) == 'wine_tasting' ? 'selected' : '' }}>🥂 Wine Tasting</option>
                            <option value="cooking_class" {{ old('event_type', $event->event_type) == 'cooking_class' ? 'selected' : '' }}>🎨 Cooking Class</option>
                            <option value="other" {{ old('event_type', $event->event_type) == 'other' ? 'selected' : '' }}>📅 Other</option>
                        </select>
                        @error('event_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" 
                              maxlength="2000" required>{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Event Date -->
                    <div class="col-md-4 mb-3">
                        <label for="event_date" class="form-label">Event Date & Time *</label>
                        <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" 
                               id="event_date" name="event_date" 
                               value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                        @error('event_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-md-4 mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                               id="location" name="location" value="{{ old('location', $event->location) }}" 
                               maxlength="500">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div class="col-md-4 mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                               id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}" 
                               min="1" placeholder="Leave empty for unlimited">
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label">Price (₦)</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', $event->price) }}" 
                               step="0.01" min="0" placeholder="Leave empty for free event">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-4 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" 
                               id="category" name="category" value="{{ old('category', $event->category) }}" 
                               maxlength="100">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-control @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Contact Email -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                               id="contact_email" name="contact_email" value="{{ old('contact_email', $event->contact_email) }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Phone -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                               id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $event->contact_phone) }}">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Event Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    @if($event->image_url)
                        <div class="mt-2">
                            <label class="form-label">Current Image:</label>
                            <div>
                                <img src="{{ $event->image_url }}" 
                                     alt="{{ $event->title }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; height: auto;"
                                     onerror="this.style.display='none'">
                            </div>
                            <small class="text-muted">Upload new image to replace current one</small>
                        </div>
                    @endif
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Event
                    </button>
                </div>
            </form>

            <!-- Delete Form -->
            <div class="mt-4 pt-3 border-top">
                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection