<?php

namespace Medlib\Listeners;

use Medlib\Services\UserMailer;
use Medlib\Events\FriendRequestWasSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailFriendRequest
{
    /**
     * @var \Medlib\Services\UserMailer
     */
    public $mailer;

    /**
     * Create the event listener.
     *
     * @param \Medlib\Services\UserMailer $mailer
     */
    public function __construct(UserMailer $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param \Medlib\Events\FriendRequestWasSent $event
     * @return \Illuminate\Mail\Mailer
     */
    public function handle(FriendRequestWasSent $event) {
        return $this->mailer->sendFriendRequestAlertTo($event->requestedUser, $event->requesterUser);
    }
}
