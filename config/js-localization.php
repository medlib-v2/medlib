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

    'locales' => ['en','fr'],

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
        'app'           => ['yes', 'no'],
        'dashboard'     => ['pending', 'pending_empty', 'running', 'running_empty', 'approving', 'approving_empty', 'deployment_number'],
        'deployments'   => ['completed', 'completed_with_errors', 'pending',
                            'deploying', 'running', 'cancelled', 'failed', ],
        'variables'     => ['create', 'edit'],
        'projects'      => ['create', 'edit', 'finished', 'pending', 'deploying', 'failed', 'not_deployed'],
        'checkUrls'     => ['create', 'edit', 'successful', 'failed', 'untested', 'length'],
        'commands'      => ['create', 'edit'],
        'groups'        => ['create', 'edit'],
        'keys'          => ['create', 'edit'],
        'links'         => ['create', 'edit'],
        'tips'          => ['create', 'edit'],
        'users'         => ['create', 'edit'],
        'templates'     => ['create', 'edit'],
        'sharedFiles'   => ['create', 'edit'],
        'configFiles'   => ['create', 'edit'],
        'notifySlacks'  => ['create', 'edit'],
        'notifyEmails'  => ['create', 'edit'],
        'servers'       => ['create', 'edit', 'successful', 'testing', 'failed', 'untested'],
        'issues'        => ['create', 'edit'],
        'heartbeats'    => ['create', 'edit', 'ok', 'untested', 'missing', 'interval_10', 'interval_30',
                            'interval_60', 'interval_120', 'interval_720', 'interval_1440', 'interval_10080', ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Set the keys of config properties you want to use in javascript.
    | Caution: Do not expose any configuration values that should be kept privately!
    |--------------------------------------------------------------------------
    */
    'config' => [
        env('APP_DEBUG', false),
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
