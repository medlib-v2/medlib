<?php

namespace Medlib\Events;

use Medlib\Events\Event;
use Medlib\Services\UserMailer;
use Medlib\Events\UserWasRegistered;

class EmailRegistrationConfirmation extends Event {

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
     * @param  UserWasRegistered  $event
     * @return \Illuminate\Mail\Mailer
     */
    public function handle(UserWasRegistered $event) {
        return $this->mailer->sendWelcomeMessageTo($event->user);
    }

}