<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 * Password Reset Notification
 * 
 * Custom notification for sending password reset links
 * Replaces Laravel's default ResetPassword notification
 * Supports Arabic and English translations
 */
class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Build reset URL with token and email
        $resetUrl = url('/api/web/password/reset?token=' . $this->token . '&email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->subject(__('messages.Reset Password Notification'))
            ->greeting(__('messages.Hello') . ' ' . $notifiable->name . '!')
            ->line(__('messages.You are receiving this email because we received a password reset request for your account.'))
            ->action(__('messages.Reset Password'), $resetUrl)
            ->line(__('messages.This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire', 60)]))
            ->line(__('messages.If you did not request a password reset, no further action is required.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
