<?php

namespace App\Notifications;

class ContactNotification extends BaseNotification
{
    public function __construct($title, $message, $data = null)
    {
        parent::__construct($title, $message, 'contact', $data);
    }
}