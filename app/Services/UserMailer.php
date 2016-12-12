<?php

namespace Medlib\Services;

use Medlib\Models\User;

class UserMailer extends EmailNotifier
{
    /**
     * Sending a welcome message to new User of Medlib.
     *
     * @param User $user
     * @return \Illuminate\Mail\Mailer
     */
    public function sendWelcomeMessageTo(User $user)
    {
        $subject = trans("emails.title_welcome_message");
        $view = 'emails.send.welcome';
        $data = [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'user_avatar' => $user->getAvatar(),
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }


    /**
     * Send alert to user when friend request is sent to him.
     *
     * @param User $requestedUser
     *
     * @param User $requesterUser
     * @return \Illuminate\Mail\Mailer
     */
    public function sendFriendRequestAlertTo(User $requestedUser, User $requesterUser)
    {
        $subject = 'Someone would like to be your friend';

        $view = 'emails.send.friend-request';

        $data = ['userFirstname' => $requestedUser->getName(), 'requesterFirstname' => $requesterUser->getName()];

        return $this->sendTo($requestedUser, $subject, $view, $data);
    }
}
