<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_item_id',
        'quantity',
        'delivery_type', // Add this
        'options', // Add this
        'special_instructions' // Add this
    ];

    protected $casts = [
        'options' => 'array'
    ];

    // Add delivery type constants
    const DELIVERY_EAT_IN = 'eat_in';
    const DELIVERY_TAKEAWAY = 'takeaway';
    const DELIVERY_HOME_DELIVERY = 'home_delivery';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function getSubtotalAttribute()
    {
        if ($this->menuItem) {
            return $this->menuItem->price * $this->quantity;
        }
        return 0;
    }

    // Helper method to get delivery type display name
    public function getDeliveryTypeDisplayAttribute()
    {
        return match($this->delivery_type) {
            self::DELIVERY_EAT_IN => 'Eat In',
            self::DELIVERY_TAKEAWAY => 'Takeaway',
            self::DELIVERY_HOME_DELIVERY => 'Home Delivery',
            default => 'Eat In'
        };
    }
}