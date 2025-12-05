<?php

namespace App\Notifications;

class OrderNotification extends BaseNotification
{
    public function __construct($title, $message, $data = null)
    {
        parent::__construct($title, $message, 'order', $data);
    }
}