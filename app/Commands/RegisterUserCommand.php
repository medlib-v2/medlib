<?php

namespace Medlib\Commands;

use Illuminate\Support\Facades\Bus;
use Medlib\Models\User;
use Medlib\Events\UserWasRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Bus\SelfHandling;

class RegisterUserCommand extends Command implements SelfHandling {

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
    protected $confirmation_code;
    protected $onlinestatus;
    protected $chatstatus;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        $email,
        $username,
        $password,
        $first_name,
        $last_name,
        $profession,
        $location = "Paris",
        $date_of_birth,
        $gender,
        $user_active = false,
        $account_type = false,
        $user_avatar,
        $confirmation_code,
        $onlinestatus = false,
        $chatstatus = true
    ) {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->profession = $profession;
        $this->location = $location;
        $this->date_of_birth = $date_of_birth;
        $this->gender = $gender;
        $this->user_active = $user_active;
        $this->account_type = $account_type;
        $this->user_avatar = $user_avatar;
        $this->confirmation_code = $confirmation_code;
        $this->onlinestatus = $onlinestatus;
        $this->chatstatus = $chatstatus;
    }

    /**
     * Handle the request
     * @return void
     */
    public function handle() {

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
            'confirmation_code' => $this->confirmation_code,
            'onlinestatus' => $this->onlinestatus,
            'chatstatus' => $this->chatstatus,
        ]);

        event(new UserWasRegistered($user));
        #$job = (new UserWasRegistered($user))->delay(60);

        #Bus::dispatch($job);

        unset($user);
    }
}