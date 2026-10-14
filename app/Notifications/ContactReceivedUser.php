<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactReceivedUser extends Notification
{
    use Queueable;

    public function __construct(public string $firstname, public string $inquiry) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('We got your message — Gotham Express')
            ->greeting("Thanks, {$this->firstname}.")
            ->line('We received your '.str_replace('_', ' ', $this->inquiry).' inquiry and will respond within 24–48 hours.')
            ->line('If it is urgent, reply to this email with any additional context.');
    }
}
