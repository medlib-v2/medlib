<?php

namespace Medlib\Commands;

use Medlib\Models\User;
use Medlib\Http\Requests\Request;
use Medlib\Events\UserWasRegistered;
use Illuminate\Support\Facades\Hash;
use Medlib\Repositories\Activation\ConfirmationTokenRepository;

class RegisterUserCommand extends Command
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
    protected $activated;
    protected $account_type;
    protected $user_avatar;
    protected $onlinestatus;
    protected $chatstatus;

    /**
     * Create a new command instance.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
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
        $this->activated = false;
        $this->account_type = false;
        $this->user_avatar = $request->get('user_avatar');
        $this->onlinestatus = false;
        $this->chatstatus = true;
    }

    /**
     * Handle the request
     *
     * @param \Medlib\Repositories\Activation\ConfirmationTokenRepository $token
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
            'activated' => $this->activated,
            'account_type' => $this->account_type,
            'user_avatar' => $this->user_avatar,
            'onlinestatus' => $this->onlinestatus,
            'chatstatus' => $this->chatstatus,
        ]);

        $token->createConfirmationToken($user);

        event(new UserWasRegistered($user));

        unset($user);
    }
}
