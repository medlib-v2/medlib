<?php

namespace Medlib\Http\Controllers\Users;

use Medlib\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Medlib\Http\Requests\DeleteUserRequest;
use Illuminate\Http\Response as IlluminateResponse;
use Medlib\Http\Requests\UpdateUserInformationRequest;

/**
 * @Middleware("auth")
 */
class SettingsController extends Controller
{
    /**
     * @Get("settings/profile", as="profile.show.settings")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile()
    {
        return view('users.settings.settings');
    }

    /**
     * @Post("settings/profile", as="profile.edit.settings")
     * @param Request $request
     */
    public function editProfile(Request $request)
    {
        dd($request);
    }

    /**
     * @Get("settings/admin", as="profile.show.admin")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdmin()
    {
        return view('users.settings.profile');
    }

    /**
     * @Post("settings/admin", as="profile.edit.admin")
     * @param UpdateUserInformationRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAdmin(UpdateUserInformationRequest $request)
    {
        $user = Auth::user();

        $user->password = bcrypt($request->get('password_new'));
        $user->save();
        $this->responseWithSuccess('Password updated');
        //return view('users.settings.email')->with('success', 'Password updated');
    }

    /**
     * @Get("settings/email", as="profile.show.email")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEmail()
    {
        return view('users.settings.email');
    }

    /**
     * @Post("settings/email", as="profile.edit.email")
     * @param Request $request
     */
    public function editEmail(Request $request)
    {
        dd($request);
    }

    /**
     * @Post("settings/avatar", as="profile.edit.avatar")
     * @param Request $request
     */
    public function editAvatar(Request $request)
    {
        /**
         * Handle the user upload of avatar
         */
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/'.$filename));
            $user = Auth::user();
            $user->user_avatar = $filename;
            $user->save();
        }
        //return view('profile', array('user' => Auth::user()) );
    }

    /**
     * @Post("settings/password", as="profile.edit.password")
     * @param Request $request
     */
    public function editPassword(Request $request)
    {
        dd($request);
    }

    /**
     * @Post("settings/username", as="profile.edit.username")
     * @param Request $request
     */
    public function editUsername(Request $request)
    {
        dd($request);
    }

    /**
     * @Post("settings/username", as="profile.delete.username")
     *
     * @param User $user
     * @param DeleteUserRequest $request
     *
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return mixed
     */
    public function deleteUsername(User $user, DeleteUserRequest $request)
    {
        dd($user);
        $this->authorize('destroy', $user);

        if ($request) {
            // validation successful!
            // deleting user
            Auth::logout();
            //return Redirect::route('home');
            return $this->response($user->delete());
        } else {
            return $this->responseWithError('Could not delete your account in with those details.');
            //return Redirect::back()->withErrors('Could not delete your account in with those details.');
        }
    }
}
