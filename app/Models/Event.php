<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'event_date',
        'event_type',
        'location',
        'capacity',
        'price',
        'contact_email',
        'contact_phone',
        'image',
        'category',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    // Event Type Options
    const EVENT_TYPES = [
        'party' => '🎉 Party',
        'corporate' => '💼 Corporate Event',
        'special_dinner' => '🍽️ Special Dinner',
        'live_music' => '🎭 Live Music',
        'wine_tasting' => '🥂 Wine Tasting',
        'cooking_class' => '🎨 Cooking Class',
        'other' => '📅 Other',
    ];

    // Status Options
    const STATUSES = [
        'draft' => 'Draft',
        'published' => 'Published',
        'cancelled' => 'Cancelled',
        'completed' => 'Completed',
    ];

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())
                    ->where('status', 'published')
                    ->orderBy('event_date');
    }

    public function scopeOngoing($query)
    {
        return $query->where('event_date', '<=', now())
                    ->where('event_date', '>=', now()->subHours(6)) // Events in last 6 hours
                    ->where('status', 'published')
                    ->orderBy('event_date');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->subHours(6))
                    ->orderBy('event_date', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Helper Methods
    public function getFormattedEventDateAttribute(): string
    {
        return $this->event_date->format('M j, Y g:i A');
    }

    public function getFormattedPriceAttribute(): ?string
    {
        if (is_null($this->price)) {
            return 'Free';
        }
        return '₦' . number_format($this->price, 2);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return Storage::disk('public')->exists($this->image) 
            ? asset('storage/' . $this->image) 
            : null;
    }

    public function getEventTypeLabelAttribute(): string
    {
        return self::EVENT_TYPES[$this->event_type] ?? 'Other';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? 'Draft';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'published' => 'bg-success',
            'draft' => 'bg-warning',
            'cancelled' => 'bg-danger',
            'completed' => 'bg-info',
            default => 'bg-secondary'
        };
    }

    public function getEventTypeBadgeClassAttribute(): string
    {
        return match($this->event_type) {
            'party' => 'bg-pink',
            'corporate' => 'bg-primary',
            'special_dinner' => 'bg-success',
            'live_music' => 'bg-purple',
            'wine_tasting' => 'bg-wine',
            'cooking_class' => 'bg-orange',
            default => 'bg-secondary'
        };
    }

    public function isUpcoming(): bool
    {
        return $this->event_date->isFuture() && $this->status === 'published';
    }

    public function isOngoing(): bool
    {
        return $this->event_date->isPast() && 
               $this->event_date->gte(now()->subHours(6)) && 
               $this->status === 'published';
    }

    public function isPast(): bool
    {
        return $this->event_date->isPast() && 
               $this->event_date->lt(now()->subHours(6));
    }

    public function isFree(): bool
    {
        return is_null($this->price) || $this->price == 0;
    }
}