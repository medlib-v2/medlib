<?php

namespace Medlib\Repositories\Activation;

use Carbon\Carbon;
use Medlib\Models\User;
use Medlib\Models\ConfirmationToken;
use Medlib\Notifications\SendConfirmationTokenEmail;

/**
 * Class ConfirmationTokenRepository
 * @package Medlib\Repositories\Activation
 */
class ConfirmationTokenRepository
{
    public function createTokenAndSendEmail(User $user)
    {
        /**
         * Limit number of ConfirmationToken attempts to 3 in 24 hours window
         */
        $ConfirmationTokens = ConfirmationToken::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->count();

        if ($ConfirmationTokens >= 3) {
            return true;
        }

        if ($user->user_active) {
            /**
             * if user changed activated email to new one
             */
            $user->update(['user_active' => false]);
        }

        /**
         * Create new ConfirmationToken record for this user/email
         */
        $ConfirmationToken = new ConfirmationToken;
        $ConfirmationToken->user_id = $user->id;
        $ConfirmationToken->token = User::generateToken();
        $ConfirmationToken->save();

        /**
         * Send ConfirmationToken email notification
         */
        $user->notify(new SendConfirmationTokenEmail($ConfirmationToken->token));
    }

    public function deleteExpiredConfirmationTokens()
    {
        ConfirmationToken::where('created_at', '<=', Carbon::now()->subHours(72))->delete();
    }
}