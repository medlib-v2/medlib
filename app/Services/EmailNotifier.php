<?php

namespace Medlib\Services;

use Medlib\Models\User;
use Illuminate\Mail\Mailer;

abstract class EmailNotifier implements EmailNotifierInterface {

    /**
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    private $mailer;

    /**
     * @param \Illuminate\Mail\Mailer $mailer
     */
    public function __construct(Mailer $mailer) {

        $this->mailer = $mailer;
    }

    /**
     * Sends a confirmation email to user after registration
     *
     * @param \Medlib\Models\User $user
     * @return \Illuminate\Mail\Mailer
     */
    public function sendRegistrationConfirmation(User $user) {

        $subject = trans("emails.title_confirmation_email");
        $view = 'emails.send.verify';
        $data = [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'user_avatar' => $user->getAvatar(),
            'confirmation_code' => $user->getConfirmationCode()
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }

    /**
     * Sends an email to user specified in this function
     *
     * @param \Medlib\Models\User $user
     * @param string $subject
     * @param string $view
     * @param array $data
     * @return boolean
     */
    public function sendTo(User $user, $subject, $view, $data = []) {

        $this->mailer->queue($view, $data, function($message) use ($user, $subject)  {
            $message->to($user->getEmail(), $user->getFirstName()." ".$user->getLastName())->subject($subject);
        });
        return true;
    }
}