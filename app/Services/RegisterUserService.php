<?php

namespace Medlib\Services;

use Medlib\Models\User;
use Medlib\Models\Profile;
use Medlib\Models\Setting;
use Medlib\Models\Timeline;
use Medlib\Http\Requests\Request;
use Illuminate\Support\Facades\DB;
use Medlib\Events\UserWasRegistered;
use Illuminate\Support\Facades\Hash;
use Medlib\Repositories\Activation\ConfirmationTokenRepository;

class RegisterUserService extends Service
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
    protected $affiliate_id;

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
        $this->affiliate_id = $request->get('affiliate_id');
    }

    /**
     * Handle the request
     *
     * @param \Medlib\Repositories\Activation\ConfirmationTokenRepository $token
     */
    public function handle(ConfirmationTokenRepository $token)
    {
        /**
         * Create timeline record for the user
         */
        $timeline = Timeline::create([
            'username' => $this->username,
            'name'     => $this->first_name. ' '. $this->last_name,
            'type'     => 'user'
        ]);

        /**
         * Create user record
         */
        $user = User::create([
            'email'             => $this->email,
            'username'          => $this->username,
            'timeline_id'       => $timeline->id,
            'password'          => Hash::make($this->password),
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'profession'        => $this->profession,
            'date_of_birth'     => $this->date_of_birth,
            'gender'            => $this->gender,
            //'affiliate_id'      => $affiliate_id,
            'activated'         => $this->activated,
            'account_type'      => $this->account_type,
            'user_avatar'       => $this->user_avatar,
            'onlinestatus'      => $this->onlinestatus,
            'chatstatus'        => $this->chatstatus,
        ]);

        /**
        if (Setting::get('birthday') == 'on' && $this->date_of_birth != '') {
            $user->date_of_birth = date('Y-m-d', strtotime($this->date_of_birth));
            $user->save();
        }
        **/

        Profile::create([
            'user_id'   => $user->id,
            'location'  => $this->location
        ]);

        /**
        if (Setting::get('location') == 'on' && $this->location != '') {
            $profile->location = $this->location;
            $profile->save();
        }
        **/

        $token->createConfirmationToken($user);

        event(new UserWasRegistered($user));

        unset($user);
    }

    /**
     * Saving default settings to user settings
     *
     * @param User $user
     * @return void
     */
    public function makeUserSettings(User $user)
    {
        $user_settings = [
            'user_id'               => $user->id,
            'confirm_follow'        => Setting::get('confirm_follow'),
            'follow_privacy'        => Setting::get('follow_privacy'),
            'comment_privacy'       => Setting::get('comment_privacy'),
            'timeline_post_privacy' => Setting::get('user_timeline_post_privacy'),
            'post_privacy'          => Setting::get('post_privacy'), ];

        /**
         * Create a record in user settings table.
         */
        DB::table('user_settings')->insert($user_settings);
    }
}
