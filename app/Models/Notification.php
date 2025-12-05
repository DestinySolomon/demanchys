<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'notifiable_type',
        'notifiable_id',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    /**
     * Get the notifiable entity that owns the notification.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Check if notification is read.
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if notification is unread.
     */
    public function isUnread()
    {
        return is_null($this->read_at);
    }

    /**
     * Get notification icon based on type.
     */
    public function getIconAttribute()
    {
        $icons = [
            'order' => 'bi-cart',
            'booking' => 'bi-calendar-check',
            'system' => 'bi-exclamation-triangle',
            'user' => 'bi-person-plus',
            'contact' => 'bi-envelope',
            'delivery' => 'bi-truck'
        ];

        return $icons[$this->type] ?? 'bi-bell';
    }

    /**
     * Get notification icon color class based on type.
     */
    public function getIconClassAttribute()
    {
        $classes = [
            'order' => 'order',
            'booking' => 'booking',
            'system' => 'system',
            'user' => 'user',
            'contact' => 'contact',
            'delivery' => 'order' // same as order for delivery
        ];

        return $classes[$this->type] ?? 'system';
    }

    /**
     * Create a new notification.
     */
    public static function createNotification($type, $title, $message, $notifiable, $data = null)
    {
        return self::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id
        ]);
    }
}