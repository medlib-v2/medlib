<?php

namespace Medlib\Listeners;

use Medlib\Services\UserMailer;
use Medlib\Events\UserWasRegistered;

class SendConfirmationEmail {

    /**
     * @var \Medlib\Services\UserMailer
     */
    private $emailNotifier;

    /**
     * Create the event handler.
     *
     * @param \Medlib\Services\UserMailer $mailer
     */
    public function __construct(UserMailer $mailer) {

        $this->emailNotifier = $mailer;

    }

    /**
     * Handle the event.
     *
     * @param  \Medlib\Events\UserWasRegistered $event
     * @return \Illuminate\Mail\Mailer
     */
    public function handle(UserWasRegistered $event) {

        return $this->emailNotifier->sendRegistrationConfirmation($event->user);

    }
}
