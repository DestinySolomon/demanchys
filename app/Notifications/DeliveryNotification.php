<?php

namespace App\Notifications;

class DeliveryNotification extends BaseNotification
{
    public function __construct($title, $message, $data = null)
    {
        parent::__construct($title, $message, 'delivery', $data);
    }
}