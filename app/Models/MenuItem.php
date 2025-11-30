<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\MenuCategory;


class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * SECURITY: Only these fields can be mass assigned
     */
    protected $fillable = [
        'menu_category_id',
        'name',
        'slug',
        'description',
        'price',
        'is_available',
        'is_featured',
        'sort_order',
        'image',
    ];

    /**
     * The attributes that should be cast.
     * SECURITY: Proper data typing
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relationship: Menu item belongs to a category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    /**
     * Relationship: Menu item has many add-ons
     */

    public function addons(): BelongsToMany
{
    return $this->belongsToMany(AddOn::class, 'menu_item_add_on')
                ->withPivot('additional_price')
                ->withTimestamps();
}

    /**
     * Accessor: Get full image URL securely
     *
     * Returns the public URL for the stored image (from storage disk)
     * or null when there is no image or an error occurs.
     */
    public function getImageUrlAttribute(): ?string
    {
        $file = $this->image;

        if (!$file) {
            return null;
        }
    
        try {
            // Check if file exists in storage
            if (Storage::disk('public')->exists($file)) {
                return asset('storage/' . $file);
            }
            
            // Fallback: check if it's already a full URL (for migrated data)
            if (filter_var($file, FILTER_VALIDATE_URL)) {
                return $file;
            }
            
            return null;
        } catch (\Exception $e) {
            // Log error and return null (fail gracefully)
            Log::error('Error generating image URL for menu item: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Scope: Available items only
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: Featured items
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where('is_available', true);
    }

    /**
     * Scope: Items by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('menu_category_id', $categoryId);
    }
}