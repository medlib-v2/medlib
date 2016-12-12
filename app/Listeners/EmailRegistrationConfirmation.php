<?php

namespace Medlib\Listeners;

use Medlib\Services\UserMailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Medlib\Events\UserRegistrationConfirmation;

class EmailRegistrationConfirmation
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
    public function __construct(UserMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistrationConfirmation  $event
     * @return \Illuminate\Mail\Mailer
     */
    public function handle(UserRegistrationConfirmation $event)
    {
        return $this->mailer->sendWelcomeMessageTo($event->user);
    }
}
