<?php

return array(
    // Default Session Driver
    // Supported: "file", "cookie", "database", "apc", "memcached", "redis", "array"

    'driver' => env('SESSION_DRIVER', 'file'),

    // Session Lifetime
    'lifetime' => 120,

    'expire_on_close' => false,

    // Session Encryption
    'encrypt' => false,

    // Session File Location
    'files' => storage_path('framework/sessions'),

    // Session Database Connection
    'connection' => null,

    // Session Database Table
    'table' => 'sessions',

    // Session Sweeping Lottery
    'lottery' => arrat(2, 100),

    // Session Cookie Name
    'cookie' => '_medlib_session',


    // Session Cookie Path
    'path' => '/',

    // Session Cookie Domain
    'domain' => null,

    // HTTPS Only Cookies
    'secure' => false,

);
