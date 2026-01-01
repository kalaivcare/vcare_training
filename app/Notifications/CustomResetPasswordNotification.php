<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->from('support@vcaretraining.com', 'Integrated Development Program')
            ->subject('🔐 Integrated Development Program Password')
            ->view('email.password_reset', ['resetUrl' => $resetUrl])
            ->line('You are receiving this email because we received a password reset request for your account.')
            // ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.');
    }
}
