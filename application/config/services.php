<?php
return array(
  // Third Party Services
  'mailgun' => array(
    'domain' => env('MAILGUN_DOMAIN'),
    'secret' => env('MAILGUN_SECRET'),
  ),

  'mandrill' => array(
    'secret' => env('MANDRILL_SECRET'),
  ),

  'ses' => array(
    'key'    => env('SES_KEY'),
    'secret' => env('SES_SECRET'),
    'region' => 'us-east-1',
  ),

  'stripe' => array(
    'model'  => App\User::class,
    'key'    => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    ),
);
