<?php

namespace Medlib\Services;

use Illuminate\Support\Facades\Bus;
use Medlib\Models\User;
use Illuminate\Support\Facades\Hash;
use Medlib\Notifications\SendSocialConfirmationTokenEmail;
use Medlib\Repositories\Activation\ConfirmationTokenRepository;

class RegisterSocialUserService extends Service
{
    protected $email;
    protected $username;
    protected $password;
    protected $firstName;
    protected $lastName;
    protected $profession;
    protected $location;
    protected $dateOfBirth;
    protected $gender;
    protected $userActive;
    protected $accountType;
    protected $userAvatar;
    protected $onlineStatus;
    protected $chatStatus;
    protected $token;

    /**
     * Create a new command instance.
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->email = $request['email'];
        $this->username = $request['username'];
        $this->password = $request['password'];
        $this->firstName = $request['first_name'];
        $this->lastName = $request['last_name'];
        $this->profession = $request['profession'];
        $this->location = (!empty($request['location']) || !$request['location'] = "") ? $request['location'] : "Paris, Ile-de-France";
        $this->dateOfBirth = $request['date_of_birth'];
        $this->gender = $request['gender'];
        $this->userActive = false;
        $this->accountType = false;
        $this->userAvatar = $request['user_avatar'];
        $this->onlineStatus = false;
        $this->chatStatus = true;

        parent::__construct();
    }

    /**
     * Create a new command instance.
     * @param array $request
     * @return array|null
     */
    public static function create(array $request)
    {
        return Bus::dispatch(new self($request));
    }

    /**
     * Handle the request
     * @param ConfirmationTokenRepository $token
     * @return \Medlib\Models\User
     */
    public function handle(ConfirmationTokenRepository $token)
    {
        $user = User::create([
            'email' => $this->email,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'profession' => $this->profession,
            'location' => $this->location,
            'date_of_birth' => $this->dateOfBirth,
            'gender' => $this->gender,
            'user_active' => $this->userActive,
            'account_type' => $this->accountType,
            'user_avatar' => $this->userAvatar,
            'onlinestatus' => $this->onlineStatus,
            'chatstatus' => $this->chatStatus,
        ]);

        $this->token = $token->createConfirmationToken($user);

        /**
         * Send activation email notification
         */
        $user->notify(new SendSocialConfirmationTokenEmail($this->token, $this->password));

        return $user;
    }
}
