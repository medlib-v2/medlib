<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */
    'driver' => env('IMAGE_DRIVER', 'gd'),
    'upload_dir'  => 'uploads',
    'upload_path' => public_path('uploads/'),
    'quality' => 100,

    'dimensions' => [
        'thumb'  => [100, 100, true,  80],
        'medium' => [600, 400, false, 90],
   ] ,

);
