<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',           // Added
        'user_id',         // Added
        'designation',
        'content',
        'rating',
        'image',
        'is_featured',
        'is_approved',
        'order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'rating' => 'integer'
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for featured testimonials
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('is_approved', true)
                     ->orderBy('order')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Scope for approved testimonials
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true)
                     ->orderBy('order')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Scope for pending approval
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope for user's testimonials
     */
    public function scopeForUser($query, $userId = null, $email = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        
        if ($email) {
            return $query->where('email', $email);
        }
        
        return $query;
    }

    /**
     * Get star rating as HTML
     */
    public function getStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="bi bi-star-fill text-warning"></i>';
            } else {
                $stars .= '<i class="bi bi-star text-warning"></i>';
            }
        }
        return $stars;
    }

    /**
     * Get status badge
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->is_approved && $this->is_featured) {
            return '<span class="badge bg-success">Featured</span>';
        } elseif ($this->is_approved) {
            return '<span class="badge bg-primary">Approved</span>';
        } else {
            return '<span class="badge bg-warning">Pending Review</span>';
        }
    }
}