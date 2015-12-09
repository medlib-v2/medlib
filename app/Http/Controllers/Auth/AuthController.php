<?php

namespace Medlib\Http\Controllers\Auth;

use Carbon\Carbon;
use Medlib\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Medlib\Exceptions\InvalidConfirmationCodeException;

class AuthController extends Controller
{
    public function showLogin() {
        return View::make('auth.login');
    }

    public function doLogin(Request $request) {

        $rules = [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ];

        /** run the validation rules on the inputs from the form */
        $validator = Validator::make($request->all(), $rules);

        /** if the validator fails, redirect back to the form */
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {

            // create our user data for the authentication
            $userdata = array(
                'email'     => $request->get('email'),
                'password'  => $request->get('password'),
                'user_active' => 1
            );

            // attempt to do the login
            if (Auth::attempt($userdata, $request->has('remember'))) {

                // validation successful!
                // redirect them to the secure section or whatever
                return Redirect::to('/');

            } else {

                // validation not successful, send back to form
                // return Redirect::to('login')->with('error', 'Could not sign you in with those details.');
                return Redirect::to('login');

            }
        }
    }

    public function showRegister() {

        return View::make('auth.register');
    }

    public function doRegister(Request $request) {

        $timestamp = strtotime('-15 years');

        $rules = [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'username' => 'required|unique:users|alpha_dash|max:20',
            'email' => 'required|unique:users|email|max:255',
            'email_confirm' => 'required|max:255|same:email',
            'profession' => 'not_in: ',
            'password' => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password',
            'birthday_day'	=>	'required|numeric|between:01,31',
            'birthday_month'	=>	'required|numeric|between:01,12',
            'birthday_year'	=>	'required|numeric|before:'.date('Y', $timestamp),
            'gender' =>	'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ];

        /** create custom validation messages */
        $messages = [
            'required' => 'The :attribute is really really really important.',
            'same'  => 'The :others must match.'
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
            return Redirect::to('register')
                ->withErrors($messages)
                ->withInput(Input::except('password', 'password_confirm'));

        } else {

            $confirmation_code = str_random(45);

            $date_of_birth = Carbon::createFromDate($request->get('year'), $request->get('month'), $request->get('day'))->toDateString();

            User::create([
                'email'    => $request->get('email'),
                'username' => $request->get('username'),
                'password' => bcrypt($request->get('password')),
                'first_name'     => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'profession' => $request->get('profession'),
                'date_of_birth' => $date_of_birth,
                'gender' => $request->get('gender'),
                'user_active' => false,
                'account_type' => false,
                'user_avatar' => '',
                'confirmation_code' => $confirmation_code
            ]);

            Mail::queue('auth.email.verify', ['code', $confirmation_code], function($message) {
                $message->to(Input::get('email'), Input::get('username'))
                    ->subject('Activate your account');
            });

            return Redirect::route('home')->with('info', 'Your account has been created with success !')
                ->with('success', 'A e-mail has been sended');
        }
    }

    public function reg_birthday() {
        return View::make('auth.reg_birthday');
    }

    public function doLogout() {
        Auth::logout();
        return Redirect::to('/');
    }

    public function doVerify($confirmation_code) {

        if(!$confirmation_code) { throw new InvalidConfirmationCodeException; }

        $user = User::where('confirmation_code', '=', $confirmation_code)->first();

        if (!$user)  { throw new InvalidConfirmationCodeException; }

        $user->user_active = true;
        $user->confirmation_code = null;
        $user->save();

        Session::flash('success', 'Success, your account has been activated.');

        return Redirect::route('auth.login');
    }
}