<?php

namespace Medlib\Services;

use Medlib\Models\User;
use Medlib\Models\SocialAccount;
use Laravel\Socialite\Two\User as UserProvider;

class SocialAccountService
{
    public function createOrGetUser(UserProvider $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
