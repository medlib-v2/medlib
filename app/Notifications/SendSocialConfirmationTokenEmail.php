<?php

namespace Medlib\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Suppress all rules containing "unused" in this
 * class SendSocialConfirmationTokenEmail
 *
 * @SuppressWarnings("unused")
 */
class SendSocialConfirmationTokenEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $password;
    /**
     * Create a new notification instance.
     * @param string $token;
     * @param string $password;
     */
    public function __construct($token, $password)
    {
        $this->token = $token;
        $this->password = $password;
        $this->onQueue('social');
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
        return (new MailMessage)
            ->subject(trans("emails.title_confirmation_email"))
            ->greeting('Hello!')
            ->line(trans('emails.activate_email_before_using'))
            ->line(trans('emails.login_user_manually') . $this->password)
            ->action(trans('emails.content_title_confirmation_email'), route('auth.verify', ['token' => $this->token, 'email' => $notifiable->email]))
            ->line(trans('emails.thank_you_for_using'));
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
