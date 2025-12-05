<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BaseNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $data;
    public $notificationType;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $notificationType, $data = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->notificationType = $notificationType;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
            'type' => $this->notificationType
        ];
    }
}