<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $table = 'gallery_images';

    protected $fillable = [
        'image_path',
        'category',
        'title',
        'description'
    ];

    // Define the allowed categories
    public const CATEGORIES = [
        'food' => '🍽️ Food & Drinks',
        'ambiance' => '🏢 Ambiance', 
        'events' => '🎉 Events',
        'people' => '👥 People',
        'special' => '🎨 Special'
    ];

    // Accessor for display name
    public function getCategoryDisplayNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}