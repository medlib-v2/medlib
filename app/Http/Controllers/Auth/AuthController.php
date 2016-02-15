<?php

namespace Medlib\Http\Controllers\Auth;

use Carbon\Carbon;
use Medlib\Models\User;
use Illuminate\Http\Request;
use Medlib\Services\ProcessImage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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

            // set the remember me cookie if the user check the box
            //$remember = ($request->has('remember')) ? true : false;

            // create our user data for the authentication
            $userdata = [
                'email'     => $request->get('email'),
                'password'  => $request->get('password'),
                //'user_active' => 1
            ];

            // attempt to do the login
            if (Auth::attempt($userdata, $request->has('remember'))) {

                // check if account is active
                if (Auth::user()->user_active == 0) {
                    Auth::logout();
                    return Redirect::guest('login')->with('info', 'Please activate your account to proceed.');
                }
                // validation successful!
                // redirect them to the secure section or whatever
                return Redirect::to('/');

            } else {

                // validation not successful, send back to form
                // return Redirect::to('login')->with('error', 'Could not sign you in with those details.');
                // return Redirect::back()->withInput()->withErrors(['credentials' => 'We were unable to sign you in.']);
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
            'day'	=>	'required|numeric|between:01,31',
            'month'	=>	'required|numeric|between:01,12',
            'year'	=>	'required|numeric|before:'.date('Y', $timestamp),
            'gender' =>	'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ];

        /** create custom validation messages */
        $messages = [
            'required' => 'The :attribute is really really important.',
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
            $userProfileImage = $profileImagePath = App::make(ProcessImage::class)->execute($request->file('profileimage'), 'avatars/', 180, 180);

            $date_of_birth = Carbon::createFromDate(
                $request->get('year'),
                $request->get('month'),
                $request->get('day')
            )->toDateString();

            $user = User::create([
                'email' => $request->get('email'),
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'profession' => $request->get('profession'),
                'location' => "",
                'date_of_birth' => $date_of_birth,
                'gender' => $request->get('gender'),
                'user_active' => false,
                'account_type' => false,
                'user_avatar' => $userProfileImage,
                'confirmation_code' => self::generateToken()
            ]);

            $account = [
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'user_avatar' => $user->getAvatar(),
                'confirmation_code' => $user->getConfirmationCode()
            ];

            Mail::queue('auth.email.verify', compact('account'), function($message) use ($user) {
                $message->to($user->getEmail(), $user->getFirstName()." ".$user->getLastName())
                    ->subject('Activate your account');
            });

            unset($user);

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

        if(!$confirmation_code) {

            return Redirect::route('home')->with('error', 'You need validation code!');
        }

        //$user = User::where('confirmation_code', '=', $confirmation_code)->first();

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user)  {

            return Redirect::route('auth.login')->with('error', 'Your validation code does not exist, check if your account is not already activated');
        }

        $user->user_active = true;
        $user->confirmation_code = null;
        $user->save();

        unset($user);

        return Redirect::route('auth.login')->with('success', 'Success, your account has been activated.');
    }

    /**
     * Generate the verification token.
     *
     * @return string
     */
    protected static function generateToken() {

        return str_random(64).config('app.key');
    }
}