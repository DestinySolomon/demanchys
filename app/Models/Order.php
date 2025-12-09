<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'order_ref',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'order_type',
        'order_status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'payment_date',
        'transaction_id',
        'subtotal',
        'tax_amount',
        'delivery_fee',
        'discount_amount',
        'discount',
        'total_amount',
        'delivery_person',
        'delivery_person_id',
        'delivery_status',
        'delivery_instructions',
        'order_date',
        'coupon_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
        'payment_date' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes for the sub-menus
    public function scopeDelivery($query)
    {
        return $query->where('order_type', 'delivery');
    }

    public function scopeEatIn($query)
    {
        return $query->where('order_type', 'eat-in');
    }

    public function scopeTakeaway($query)
    {
        return $query->where('order_type', 'takeaway');
    }

    // Helper Methods
    public function getFormattedTotalAttribute(): string
    {
        return '₦' . number_format($this->total_amount, 2);
    }

    public function getFormattedOrderDateAttribute(): string
    {
        return $this->order_date->format('M j, Y g:i A');
    }

    /**
 * Get the delivery man for this order
 */
public function deliveryMan()
{
    return $this->belongsTo(DeliveryMan::class, 'delivery_person_id');
}
}
    