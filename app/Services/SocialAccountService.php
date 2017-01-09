<?php

namespace Medlib\Services;

use Medlib\Models\User;
use Faker\Factory as Faker;
use Medlib\Models\SocialAccount;
use Laravel\Socialite\Two\User as UserProvider;

class SocialAccountService
{
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param \Laravel\Socialite\Two\User $providerUser
     * @param string $provider
     * @return User
     */
    public static function findOrCreateUser(UserProvider $providerUser, $provider)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        $account = new SocialAccount([
            'provider_user_id' => $providerUser->getId(),
            'provider' => $provider
        ]);

        $user = User::whereEmail($providerUser->getEmail())->first();

        if (is_null($user)) {
            $faker = Faker::create();
            $user = RegisterSocialUserService::create([
                'email' => $providerUser->user['email'],
                'username' => $providerUser->name ? $providerUser->name : self::generateUsername($providerUser),
                'password' => str_random(8),
                'first_name' => $providerUser->user['first_name'],
                'last_name' => $providerUser->user['last_name'],
                'profession' => $faker->randomElement(['student','researcher', 'teacher']),
                'location' => '',
                'date_of_birth' => $faker->date,
                'gender' => $providerUser->user['gender'],
                'user_avatar' => $providerUser->getAvatar()
            ]);
        }

        $account->user()->associate($user);
        $account->save();

        return $user;
    }

    /**
     * @param \Laravel\Socialite\Two\User $providerUser
     *
     * @return null|string
     */
    protected static function generateUsername(UserProvider $providerUser)
    {
        $username = null;

        $username = substr(strtolower($providerUser->user['first_name']), 0, 1);
        $username .= "_";
        $username .= strtolower($providerUser->user['last_name']);

        return  $username;
    }
}
