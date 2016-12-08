<?php

namespace Medlib\Listeners;

use Medlib\Models\User;
use Medlib\Models\ConfirmationToken;
use Medlib\Events\UserWasRegistered;
use Medlib\Notifications\SendConfirmationTokenEmail;

class SendConfirmationEmail {


    /**
     * @var \Medlib\Models\User
     */
    private $user;

    /**
     * Create the event handler.
     *
     * @param \Medlib\Models\User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  \Medlib\Events\UserWasRegistered $event
     * @return boolean
     */
    public function handle(UserWasRegistered $event) {

        $ConfirmationToken = ConfirmationToken::where('user_id', $event->user->id)->firstOrFail();

        $event->user->notify(new SendConfirmationTokenEmail($ConfirmationToken->getToken()));
        return true;

    }
}
