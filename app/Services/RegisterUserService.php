<?php

namespace Medlib\Services;

use Medlib\Models\Media;
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
    protected $firstName;
    protected $lastName;
    protected $profession;
    protected $location;
    protected $dateOfBirth;
    protected $gender;
    protected $activated;
    protected $accountType;
    protected $userAvatar;
    protected $onlineStatus;
    protected $chatStatus;
    protected $affiliateId;

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
        $this->firstName = $request->get('first_name');
        $this->lastName = $request->get('last_name');
        $this->profession = $request->get('profession');
        $this->location = $request->get('location') ? $request->get('location') : "Paris, Ile-de-France";
        $this->dateOfBirth = $request->get('date_of_birth');
        $this->gender = $request->get('gender');
        $this->activated = false;
        $this->accountType = false;
        $this->userAvatar = $request->get('user_avatar');
        $this->onlineStatus = false;
        $this->chatStatus = true;
        $this->affiliateId = $request->get('affiliate_id');
    }

    /**
     * Handle the request
     *
     * @param \Medlib\Repositories\Activation\ConfirmationTokenRepository $token
     */
    public function handle(ConfirmationTokenRepository $token)
    {
        $name = $this->firstName. ' '. $this->lastName;

        $avatar = Media::create([
            'name'  => $name,
            'type'   => 'image',
            'source' => $this->userAvatar
        ]);

        /**
         * Create timeline record for the user
         */
        $timeline = Timeline::create([
            'username' => $this->username,
            'name'     => $name,
            'type'     => 'user',
            'avatar_id' => $avatar->id
        ]);

        /**
         * Create user record
         */
        $user = User::create([
            'email'             => $this->email,
            'username'          => $this->username,
            'timeline_id'       => $timeline->id,
            'password'          => Hash::make($this->password),
            'first_name'        => $this->firstName,
            'last_name'         => $this->lastName,
            'profession'        => $this->profession,
            'date_of_birth'     => $this->dateOfBirth,
            'gender'            => $this->gender,
            //'affiliate_id'      => $affiliateId,
            'activated'         => $this->activated,
            'account_type'      => $this->accountType,
            'onlinestatus'      => $this->onlineStatus,
            'chatstatus'        => $this->chatStatus,
        ]);

        /**
        if (Setting::get('birthday') == 'on' && $this->date_of_birth != '') {
            $user->date_of_birth = date('Y-m-d', strtotime($this->dateOfBirth));
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
        $this->makeUserSettings($user);

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
        $userSettings = [
            'user_id'               => $user->id,
            'confirm_follow'        => Setting::get('confirm_follow'),
            'follow_privacy'        => Setting::get('follow_privacy'),
            'comment_privacy'       => Setting::get('comment_privacy'),
            'timeline_post_privacy' => Setting::get('user_timeline_post_privacy'),
            'post_privacy'          => Setting::get('post_privacy'), ];

        /**
         * Create a record in user settings table.
         */
        DB::table('user_settings')->insert($userSettings);
    }
}
