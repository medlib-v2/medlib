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
    protected $first_name;
    protected $last_name;
    protected $profession;
    protected $location;
    protected $date_of_birth;
    protected $gender;
    protected $user_active;
    protected $account_type;
    protected $user_avatar;
    protected $onlinestatus;
    protected $chatstatus;
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
        $this->first_name = $request['first_name'];
        $this->last_name = $request['last_name'];
        $this->profession = $request['profession'];
        $this->location = (!empty($request['location']) || !$request['location'] = "") ? $request['location'] : "Paris, Ile-de-France";
        $this->date_of_birth = $request['date_of_birth'];
        $this->gender = $request['gender'];
        $this->user_active = false;
        $this->account_type = false;
        $this->user_avatar = $request['user_avatar'];
        $this->onlinestatus = false;
        $this->chatstatus = true;

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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'profession' => $this->profession,
            'location' => $this->location,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'user_active' => $this->user_active,
            'account_type' => $this->account_type,
            'user_avatar' => $this->user_avatar,
            'onlinestatus' => $this->onlinestatus,
            'chatstatus' => $this->chatstatus,
        ]);

        $this->token = $token->createConfirmationToken($user);

        /**
         * Send activation email notification
         */
        $user->notify(new SendSocialConfirmationTokenEmail($this->token, $this->password));

        return $user;
    }
}
