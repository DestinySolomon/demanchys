<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    /**
     * Get the notification's type from data.
     */
    public function getNotificationTypeAttribute()
    {
        $data = $this->data;
        return $data['type'] ?? 'system';
    }

    /**
     * Get the notification's title from data.
     */
    public function getNotificationTitleAttribute()
    {
        $data = $this->data;
        return $data['title'] ?? 'Notification';
    }

    /**
     * Get the notification's message from data.
     */
    public function getNotificationMessageAttribute()
    {
        $data = $this->data;
        return $data['message'] ?? '';
    }

    /**
     * Get notification icon.
     */
    public function getIconAttribute()
    {
        $type = $this->notification_type;
        
        $icons = [
            'order' => 'bi-cart',
            'booking' => 'bi-calendar-check',
            'system' => 'bi-exclamation-triangle',
            'user' => 'bi-person-plus',
            'contact' => 'bi-envelope',
            'delivery' => 'bi-truck'
        ];

        return $icons[$type] ?? 'bi-bell';
    }

    /**
     * Get notification icon class.
     */
    public function getIconClassAttribute()
    {
        $type = $this->notification_type;
        
        $classes = [
            'order' => 'order',
            'booking' => 'booking',
            'system' => 'system',
            'user' => 'user',
            'contact' => 'contact',
            'delivery' => 'order'
        ];

        return $classes[$type] ?? 'system';
    }

    /**
     * Get formatted time ago.
     */
    public function getTimeAgoAttribute()
    {
        $seconds = now()->diffInSeconds($this->created_at);
        
        if ($seconds < 60) return 'just now';
        if ($seconds < 3600) return floor($seconds / 60) . 'm ago';
        if ($seconds < 86400) return floor($seconds / 3600) . 'h ago';
        return floor($seconds / 86400) . 'd ago';
    }
}