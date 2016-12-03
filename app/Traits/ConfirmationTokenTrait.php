<?php

namespace Medlib\Traits;

use Medlib\Models\User;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\Activation\ConfirmationTokenRepository;

trait ConfirmationTokenTrait
{
    /**
     * @param \Medlib\Models\User $user
     *
     * @return bool
     */
    public function initiateEmailActivation(User $user)
    {
        if ( !config('settings.activation')  || !$this->validateEmail($user)) {
            return true;
        }
        $activationRepostory = new ConfirmationTokenRepository();
        $activationRepostory->createTokenAndSendEmail($user);
    }

    /**
     * @param \Medlib\Models\User $user
     *
     * @return bool
     */
    protected function validateEmail(User $user)
    {
        /**
         * Check does email posses valid format, cause if it's social account without
         * email, it'll have value of missing
         */
        $validator = Validator::make(['email' => $user->email], ['email' => 'required|email']);
        if ($validator->fails()) {
            /**
             * Stopping job execution, if it return false it will break entire application
             */
            return false;
        }
        return true;
    }
}