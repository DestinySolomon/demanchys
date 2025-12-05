<?php

namespace App\Notifications;

class SystemNotification extends BaseNotification
{
    public function __construct($title, $message, $data = null)
    {
        parent::__construct($title, $message, 'system', $data);
    }
}