<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactReceivedAdmin extends Notification
{
    use Queueable;

    public function __construct(public ContactMessage $message) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New contact inquiry — '.ucfirst($this->message->inquiry))
            ->greeting('New contact form submission')
            ->line('From: '.$this->message->firstname.' <'.$this->message->email.'>')
            ->line('Type: '.ucfirst($this->message->inquiry))
            ->line('Message:')
            ->line($this->message->message)
            ->line('Reply directly to the sender.');
    }
}
