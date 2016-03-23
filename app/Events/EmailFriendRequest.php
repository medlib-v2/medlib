<?php

namespace Medlib\Events;

use Medlib\Events\Event;
use Medlib\Services\UserMailer;
use Medlib\Events\FriendRequestWasSent;

class EmailFriendRequest extends Event {

    /**
     * @var \Medlib\Services\UserMailer
     */
    public $mailer;

    /**
     * Create the event handler.
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
     * @return void
     */
    public function handle(FriendRequestWasSent $event) {
        $this->mailer->sendFriendRequestAlertTo($event->requestedUser, $event->requesterUser);
    }


}
