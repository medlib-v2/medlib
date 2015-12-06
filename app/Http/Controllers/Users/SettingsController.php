<?php

namespace Medlib\Http\Controllers\Users;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller {


    public function showProfile() {

        return view('users.settings.settings');
    }

    public function editProfile(Request $request) {

        dd($request);
    }

    public function showAdmin() {

        return view('users.settings.profile');
    }

    public function editAdmin(Request $request) {

        dd($request);
    }

    public function showEmail() {

        return view('users.settings.email');
    }

    public function editEmail(Request $request) {

        dd($request);
    }

    public function editAvatar(Request $request) {

        dd($request);
    }

    public function editPassword(Request $request) {

        dd($request);

    }

    public function editUsername(Request $request) {

        dd($request);
    }

    public function deleteUsername($username, Request $request) {

        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required|recaptcha',
        ];

        /** create custom validation messages */
        $messages = [
            'required' => 'The :attribute is really really important.'
        ];

        /**
         * Do the validation
         * validate against the inputs from our form
         */
        $validator = Validator::make($request->all(), $rules, $messages);

        // check if the validator failed
        if ($validator->fails()) {

            /** get the error messages from the validator */
            $messages = $validator->messages();

            /** redirect our user back to the form with the errors from the validator */
            return Redirect::back()
                ->withErrors($messages)
                ->withInput(Input::except('password'));

        } else {

            dd($username);
            /** attempt to do the login
            if () {

                // validation successful!
                // deleting user
                dd($username);
                Auth::logout();
                return Redirect::to('/');

            } else {

                // validation not successful, send back to form
                // return Redirect::to('login')->with('error', 'Could not sign you in with those details.');
                return Redirect::back()->withErrors('Could not delete your account in with those details.');

            }
            */
        }
    }
}