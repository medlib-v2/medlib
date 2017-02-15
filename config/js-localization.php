<?php

/*
 * This file is part of Medlib.
 *
 * Copyright (C) 2016 Medlib.fr
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Define the languages you want exported messages for
    |--------------------------------------------------------------------------
    */

    'locales' => ['fr','en'],

    /*
    |--------------------------------------------------------------------------
    | Define the messages to export
    |--------------------------------------------------------------------------
    |
    | An array containing the keys of the messages you wish to make accessible
    | for the Javascript code.
    | Remember that the number of messages sent to the browser influences the
    | time the website needs to load. So you are encouraged to limit these
    | messages to the minimum you really need.
    |
    | Supports nesting:
    |   [ 'mynamespace' => ['test1', 'test2'] ]
    | for instance will be internally resolved to:
    |   ['mynamespace.test1', 'mynamespace.test2']
    |
    */
    'messages' => [
        'app'   => ['name', 'description', 'about', 'dashboard', 'groups', 'users', 'notifications', 'created', 'edit', 'custom','confirm',
            'confirm_title', 'confirm_text', 'not_applicable', 'date', 'status', 'details', 'delete', 'save', 'close', 'never', 'none',
            'yes', 'no', 'warning','socket_error', 'socket_error_info'],
        'auth'  => ['medlib_title', 'medlib_register_message', 'failed', 'throttle', 'btn' => ['login', 'forgot_password'],
            'txt' => ['spacer_or', 'remember_me', 'forgot_password', 'sing_up', 'email', 'email_placeholder', 'email_confirm_placeholder',
                'password', 'password_confirm', 'forgot_email', 'forgot_email_end', 'dont_have_account', 'first_name', 'last_name',
                'login', 'profession' => ['title', 'student', 'teacher', 'researcher', 'placeholder'], 'birthday' => ['title', 'day', 'month', 'year'],
                'gender' => ['male','female'], 'profile_image'],
            'account_created_success', 'email_was_sent', 'login' => ['can_not_login', 'failed'],
            'validation' => ['validation_code_does_not_exist', 'validation_code_has_expired', 'account_has_been_activated', 'need_validation_code'],
            'user_information_login', 'user_title_login', 'account_dont_have', 'available', 'unavailable', 'friends_del', 'friends_send_request', 'friends_accept_request',
            'friends_remove_request', 'friends_dont_have', 'settings'
                            ],
        'emails' => ['title_confirmation_email', 'title_welcome_message', 'content_title_confirmation_email', 'content_title_password_reset', 'content_title_confirmation_success',
            'login_user_manually', 'activate_email_before_using', 'thank_you_for_using', 'login_user_now', 'send_friend_request'],
        'messages' => ['problems_with_input', 'token_mismatch_exception', 'error_message'],
        'pagination' => ['previous', 'next'],
        'passwords' => ['password', 'reset', 'sent', 'token', 'user', 'reset_password', 'reset_password_subtitle', 'send_reset_password',
            'password_text', 'password_confirm_text'],
        'search' => [
            'btn' => ['find'],
            'txt' => ['advanced_search', 'advanced', 'criteria', 'abstract', 'keywords', 'dofpublisher', 'uniforme', 'publisher',
                'author', 'title', 'source', 'library', 'search_results',
                'sort_by' => ['default', 'title_asc', 'title_desc', 'date_asc', 'date_desc', 'author_a_z', 'author_z_a', 'number_asc', 'number_desc'],
                'number_pages' => ['10_par_page', '20_par_page', '50_par_page', 'all_page'],
                'reset', 'go_back', 'select' => ['check_all', 'clear_all'],
                'of', 'format', 'refine', 'show', 'hide'
            ],
            'advanced' => [
                'type_doc' => ['all', 'a', 'i', 'e', 'g', 'h', 's', 'r', 't', 'o', 'p', 'am', 'm', 'f', 'j', 'c', 'd', 'k'],
                'date_of_publication_creation', 'predefined_year', 'every_year', 'last_year', 'five_last_years', 'ten_last_years', 'from', 'to'
            ],
            'icons' => ['all', 'images', 'books', 'videos']
        ],
        'notifications' => ['view_all_notifications', 'accept_request', 'cancel_request', 'accepted_friend_request', 'send_friend_request'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Set the keys of config properties you want to use in javascript.
    | Caution: Do not expose any configuration values that should be kept privately!
    |--------------------------------------------------------------------------
    */
    'config' => [
        'app.debug'
    ],

    /*
    |--------------------------------------------------------------------------
    | Disables the config cache if set to true, so you don't have to
    | run `php artisan js-localization:refresh` each time you change configuration files.
    | Attention: Should not be used in production mode due to decreased performance.
    |--------------------------------------------------------------------------
    */
    'disable_config_cache' => env('APP_DEBUG', false),

];
