<?php

namespace Medlib\Listeners;

use Medlib\Models\User;
use Medlib\Events\UserRegistrationConfirmation;
use Medlib\Notifications\SendWelcomeMessageEmail;

class EmailRegistrationConfirmation
{
    /**
     * @var \Medlib\Services\UserMailer
     */
    public $user;

    /**
     * Create the event listener.
     *
     * @param \Medlib\Models\User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistrationConfirmation  $event
     * @return \Illuminate\Mail\Mailer
     */
    public function handle(UserRegistrationConfirmation $event)
    {
        return $this->user->notify(new SendWelcomeMessageEmail($event->user));
    }
}
