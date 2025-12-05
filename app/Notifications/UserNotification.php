<?php

namespace App\Notifications;

class UserNotification extends BaseNotification
{
    public function __construct($title, $message, $data = null)
    {
        parent::__construct($title, $message, 'user', $data);
    }
}