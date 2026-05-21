<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotificationMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
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
            ->subject('Fruitkha - Reset Your Password 🔐')

            ->greeting('Hello from Fruitkha 🍍')

            ->line('We received a request to reset your password for your Fruitkha admin account.')

            ->line('Click the button below to securely reset your password.')

            ->action('Reset Password', url('/reset-password/'.$this->token.'?email='.$notifiable->email))

            ->line('This password reset link will expire in 60 minutes.')

            ->line('If you did not request a password reset, no further action is required.')

            ->salutation('Regards, Fruitkha Team 🍍');
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
