<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'image_path',
        'url',
        'order',
        'is_active',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function scopePromotional($query)
    {
        return $query->where('type', 'promotional');
    }

    public function scopeOffers($query)
    {
        return $query->where('type', 'offer');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getIsCurrentlyActiveAttribute()
    {
        if (!$this->is_active) return false;
        $now = now();
        if ($this->start_date && $this->start_date->gt($now)) return false;
        if ($this->end_date && $this->end_date->lt($now)) return false;
        return true;
    }
}