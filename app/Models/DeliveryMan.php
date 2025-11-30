<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'gender',
        'avatar',
        'status',
        'total_earnings',
        'commission_rate',
        'available_balance',
        'total_withdrawn',
        'pending_withdrawal',
        'address',
        'vehicle_type',
        'vehicle_number',
        'last_active'
    ];

    protected $casts = [
        'total_earnings' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'available_balance' => 'decimal:2',
        'total_withdrawn' => 'decimal:2',
        'pending_withdrawal' => 'decimal:2',
        'last_active' => 'datetime'
    ];

    /**
     * Get the orders assigned to this delivery man
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_person_id');
    }

    /**
     * Calculate commission deducted
     */
    public function getCommissionDeductedAttribute()
    {
        return $this->total_earnings * ($this->commission_rate / 100);
    }

    /**
     * Calculate net earnings
     */
    public function getNetEarningsAttribute()
    {
        return $this->total_earnings - $this->commission_deducted;
    }

    /**
     * Get active orders count
     */
    public function getActiveOrdersCountAttribute()
    {
        return $this->orders()->where('order_status', 'pending')->count();
    }

    /**
     * Get completed orders count
     */
    public function getCompletedOrdersCountAttribute()
    {
        return $this->orders()->where('order_status', 'completed')->count();
    }
}