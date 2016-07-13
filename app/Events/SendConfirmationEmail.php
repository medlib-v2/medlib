<?php

namespace Medlib\Events;

use Medlib\Events\Event;
use Medlib\Services\UserMailer;
use Medlib\Events\UserWasRegistered;

class SendConfirmationEmail extends Event {

    /**
     * @var EmailNotifierInterface
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