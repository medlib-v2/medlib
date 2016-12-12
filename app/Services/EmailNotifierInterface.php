<?php

namespace Medlib\Services;

use Medlib\Models\User;

interface EmailNotifierInterface
{

    /**
     * Sends a confirmation email to user after registration
     *
     * @param \Medlib\Models\User $user
     * @return \Illuminate\Mail\Mailer
     */
    public function sendRegistrationConfirmation(User $user);

    /**
     * Sends an email to user specified in this function
     *
     * @param \Medlib\Models\User $user
     * @param string $subject
     * @param string $view
     * @param array $data
     * @return \Illuminate\Mail\Mailer
     */
    public function sendTo(User $user, $subject, $view, $data = []);
}
