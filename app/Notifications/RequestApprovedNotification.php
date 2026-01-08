<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestApprovedNotification extends Notification
{
    use Queueable;
     public string $requestType;
    /**
     * Create a new notification instance.
     */
     public function __construct(string $requestType)
    {
        $this->requestType = $requestType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
       return (new MailMessage)
            ->subject('Your Request Has Been Approved')
            ->greeting('Good day, ' . $notifiable->name . '!')
            ->line("Your {$this->requestType} request has been approved.")
            ->line("Approved by: System Administrator")
            ->line('Thank you for using our TMCNHS System.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
