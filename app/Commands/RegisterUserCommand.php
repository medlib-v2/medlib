<?php

namespace Medlib\Commands;

use Medlib\Models\User;
use Medlib\Http\Requests\Request;
use Medlib\Events\UserWasRegistered;
use Illuminate\Support\Facades\Hash;

class RegisterUserCommand extends Command {

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
     * @param Request $request
     */
    public function __construct(Request $request) {

        parent::__construct();

        $this->email = $request->get('email');
        $this->username = $request->get('username');
        $this->password = $request->get('password');
        $this->first_name = $request->get('first_name');
        $this->last_name = $request->get('last_name');
        $this->profession = $request->get('profession');
        $this->location = $request->get('location') ? $request->get('location') : "Paris, Ile-de-France";
        $this->date_of_birth = $request->get('date_of_birth');
        $this->gender = $request->get('gender');
        $this->user_active = false;
        $this->account_type = false;
        $this->user_avatar = $request->get('user_avatar');
        $this->confirmation_code = $request->get('confirmation_code');
        $this->onlinestatus = false;
        $this->chatstatus = true;
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

        unset($user);
    }
}