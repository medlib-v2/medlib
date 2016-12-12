<?php

namespace Medlib\Commands;

use Medlib\Models\User;
use Illuminate\Support\Facades\Hash;
use Medlib\Notifications\SendConfirmationTokenEmail;

class RegisterSocialUserCommand extends Command
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
    protected $facebook_id;
    protected $user_active;
    protected $account_type;
    protected $user_avatar;
    protected $confirmation_code;
    protected $onlinestatus;
    protected $chatstatus;

    /**
     * Create a new command instance.
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct();

        $this->email = $request['email'];
        $this->username = $request['username'];
        $this->password = $request['password'];
        $this->first_name = $request['first_name'];
        $this->last_name = $request['last_name'];
        $this->profession = $request['profession'];
        $this->location = $request['location'] ? $request['location'] : "Paris, Ile-de-France";
        $this->date_of_birth = $request['date_of_birth'];
        $this->gender = $request['gender'];
        $this->facebook_id = $request['facebook_id'];
        $this->user_active = false;
        $this->account_type = false;
        $this->user_avatar = $request['user_avatar'];
        $this->confirmation_code = $request['confirmation_code'];
        $this->onlinestatus = false;
        $this->chatstatus = true;
    }

    /**
     * Create a new command instance.
     * @param array $request
     */
    public static function create(array $request)
    {
        new self($request);
    }

    /**
     * Handle the request
     * @return \Medlib\Models\User
     */
    public function handle()
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
            'facebook_id' => $this->facebook_id,
            'user_avatar' => $this->user_avatar,
            'confirmation_code' => $this->confirmation_code,
            'onlinestatus' => $this->onlinestatus,
            'chatstatus' => $this->chatstatus,
        ]);

        /**
         * Send activation email notification
         */
        $user->notify(new SendConfirmationTokenEmail($this->confirmation_code));

        return $user;
    }
}
