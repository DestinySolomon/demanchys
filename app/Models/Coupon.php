<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_uses',
        'used_count',
        'valid_from',
        'valid_to',
        'is_active'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
        'is_active' => 'boolean'
    ];

    // Check if coupon is valid
    public function isValid($orderAmount = 0)
    {
        if (!$this->is_active) {
            return false;
        }

        if (now()->lt($this->valid_from) || now()->gt($this->valid_to)) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    // Calculate discount amount
    public function calculateDiscount($amount)
    {
        if ($this->discount_type === 'percentage') {
            return ($amount * $this->discount_value) / 100;
        } else {
            return min($this->discount_value, $amount);
        }
    }
}