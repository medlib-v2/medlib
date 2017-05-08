<?php

namespace Medlib\Notifications;

use Medlib\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

/**
 * Suppress all rules containing "unused" in this
 * class SendConfirmationRequestAccepted
 *
 * @SuppressWarnings("unused")
 */
class SendConfirmationRequestAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast','database', WebPushChannel::class];
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
            ->line($this->user->getName() . ' '. trans('notifications.accepted_friend_request'))
            ->action('View profile', route('profile.user.show', ['username' => $this->user->getUsername()]))
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
            'type'  => 'accepted_friend_request',
            'username' => $this->user->getUsername(),
            'full_name' => $this->user->getName(),
            'user_avatar' => $this->user->getAvatar(),
            'message' => trans('notifications.accepted_friend_request'),
            'profile_url' => route('profile.user.show', ['username' => $this->user->getUsername()])
        ];
    }

    /**
     * Get the web push representation of the notification.
     *
     * @param  mixed  $notifiable
     * @param  mixed  $notification
     * @return \Illuminate\Notifications\Messages\DatabaseMessage|WebPushMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->id($notification->id)
            ->title($this->user->getName(). ' accepted your friend request')
            ->icon($this->user->getAvatar())
            ->body(trans('notifications.accepted_friend_request'))
            ->action(trans('emails.view_profile'), route('profile.user.show', ['username' => $this->user->getUsername()]));
    }
}
