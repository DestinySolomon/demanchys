<?php

namespace App\Notifications;

class BookingNotification extends BaseNotification
{
    public function __construct($title, $message, $data = null)
    {
        parent::__construct($title, $message, 'booking', $data);
    }
}