<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'btn'=> [
        'login' => 'Login',
    ],
    'txt' => [
        'remember_me' => 'Remember me',
        'forgot_passwd' => 'Forgot your password ?',
        'sing_up' => 'Sing up',
        'email' => 'Email',
        'password' => 'Password',
    ],
    'account_created_success' => 'Your account has been created with success !',
    'email_was_sent' => 'A email has been sent',
    'login' => [
        'failed' => 'We were unable to sign you in. Please check your credentials and try again.'
    ],
    'validation' => [
        'validation_code_does_not_exist' => 'Your validation code does not exist, check if your account is not already activated',
        'validation_code_has_expired' => 'Your validation code has expired. Please use the reset link within one hour.',
        'account_has_been_activated' => 'Success, your account has been activated.',
        'need_validation_code' => 'You need validation code!'
    ],
];
