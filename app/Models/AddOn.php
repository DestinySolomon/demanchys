<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class AddOn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'additional_price',
        'is_available',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'additional_price' => 'decimal:2',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot function for automatic slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($addOn) {
            if (empty($addOn->slug)) {
                $addOn->slug = Str::slug($addOn->name);
            }
        });

        static::updating(function ($addOn) {
            if ($addOn->isDirty('name') && empty($addOn->slug)) {
                $addOn->slug = Str::slug($addOn->name);
            }
        });
    }

    /**
     * Relationship: Add-on belongs to many menu items
     */
    public function menuItems(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_add_on')
                    ->withPivot('additional_price')
                    ->withTimestamps();
    }

    /**
     * Scope: Available add-ons only
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: Ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Accessor: Formatted price with currency
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₦' . number_format($this->additional_price, 2);
    }

    /**
     * Check if add-on is linked to any menu items
     */
    public function hasMenuItems(): bool
    {
        return $this->menuItems()->exists();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}