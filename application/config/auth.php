<?php

return array(

  // Default Authentication Driver
  'driver' => 'database',

  // Authentication Model
  'model' => App\User::class,

  // Authentication Table
  'table' => 'users',

  // Password Reset Settings
  'password' => array(
    'email' => 'emails.password',
    'table' => 'password_resets',
    'expire' => 60,
  ),
);
