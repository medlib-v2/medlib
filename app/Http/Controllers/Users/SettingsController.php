<?php

namespace Medlib\Http\Controllers\Users;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Medlib\Http\Requests\DeleteUserRequest;

/**
 * @Middleware("auth")
 */
class SettingsController extends Controller {

    /**
     * @Get("settings/profile", as="profile.show.settings")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile() {

        return view('profile.show.settings\'');
    }

    /**
     * @Post("settings/profile", as="profile.edit.settings")
     * @param Request $request
     */
    public function editProfile(Request $request) {

        dd($request);
    }

    /**
     * @Get("settings/admin", as="profile.show.admin")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdmin() {

        return view('users.settings.profile');
    }

    /**
     * @Post("settings/admin", as="profile.edit.admin")
     * @param Request $request
     */
    public function editAdmin(Request $request) {

        dd($request);
    }

    /**
     * @Get("settings/email", as="profile.show.email")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEmail() {

        return view('users.settings.email');
    }

    /**
     * @Post("settings/email", as="profile.edit.email")
     * @param Request $request
     */
    public function editEmail(Request $request) {

        dd($request);
    }

    /**
     * @Post("settings/avatar", as="profile.edit.avatar")
     * @param Request $request
     */
    public function editAvatar(Request $request) {

        dd($request);
    }

    /**
     * @Post("settings/password", as="profile.edit.password")
     * @param Request $request
     */
    public function editPassword(Request $request) {

        dd($request);

    }

    /**
     * @Post("settings/username", as="profile.edit.username")
     * @param Request $request
     */
    public function editUsername(Request $request) {

        dd($request);
    }

    /**
     * @Post("settings/username", as="profile.delete.username")
     * @param $username
     * @param DeleteUserRequest $request
     * @return mixed
     */
    public function deleteUsername($username, DeleteUserRequest $request) {

        dd($username);

        if ($request) {
            // validation successful!
            // deleting user
            Auth::logout();
            return Redirect::to('/');

        } else {
            return Redirect::back()->withErrors('Could not delete your account in with those details.');
        }



    }
}