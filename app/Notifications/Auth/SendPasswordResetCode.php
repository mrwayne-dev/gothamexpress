<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPasswordResetCode extends Notification
{
    use Queueable;

    public function __construct(public string $code, public int $expiresInMinutes, public int $maxAttempts) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Gotham Express password reset code')
            ->greeting('Password reset requested')
            ->line('Use this code to reset your Gotham Express password:')
            ->line('**'.$this->code.'**')
            ->line('This code expires in '.$this->expiresInMinutes.' minutes and allows up to '.$this->maxAttempts.' attempts.')
            ->line('If you did not request a password reset, no further action is required.');
    }
}
