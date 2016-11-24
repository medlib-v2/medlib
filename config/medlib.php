<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Credentials
    |--------------------------------------------------------------------------
    |
    | When running `php artisan koel:init` the admin is set using the .env
    |
    */

    'admin' => [
        'name' => env('ADMIN_NAME'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sync Options
    |--------------------------------------------------------------------------
    |
    | A timeout is set when using the browser to scan the folder path
    |
    */

    'sync' => [
        'timeout' => env('APP_MAX_SCAN_TIME', 600),
    ],

    /*
    |--------------------------------------------------------------------------
    | Youtube Integration
    |--------------------------------------------------------------------------
    |
    | Youtube integration requires an youtube API key, see wiki for more
    |
    */

    'youtube' => [
        'key' => env('YOUTUBE_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | CDN
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'cdn' => [
        'url' => env('CDN_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Downloading Music
    |--------------------------------------------------------------------------
    |
    | Koel provides the ability to prohibit or allow [default] downloading music
    |
    */

    'download' => [
        'allow' => env('ALLOW_DOWNLOAD', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Ignore Dot Files
    |--------------------------------------------------------------------------
    |
    | Ignore dot files and folders when scanning for media files.
    |
    */
    'ignore_dot_files' => env('IGNORE_DOT_FILES', true),

];