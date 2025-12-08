<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'mobile_number',
        'bio',
        'profile_image',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
    ];

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getOrderStatistics()
    {
        return [
            'active' => $this->orders()->where('order_status', 'pending')->count(),
            'pending' => $this->orders()->where('order_status', 'pending')->count(),
            'completed' => $this->orders()->where('order_status', 'completed')->count(),
            'cancelled' => $this->orders()->where('order_status', 'cancelled')->count(),
        ];
    }

    /**
 * Get the user's wishlist items.
 */
public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}
}