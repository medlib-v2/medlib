<?php

return array(
  // Mail Driver
  // Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill", "ses", "log"

  'driver' => env('MAIL_DRIVER', 'smtp'),

  // SMTP Host Address
  'host' => env('MAIL_HOST', 'smtp.gmail.com'),

  // SMTP Host Port
  'port' => env('MAIL_PORT', 587),

  // Global "From" Address
  'from' => array('address' => null, 'name' => null),

  // E-Mail Encryption Protocol
  'encryption' => env('MAIL_ENCRYPTION', 'tls'),

  // SMTP Server Username
  'username' => env('MAIL_USERNAME'),

  // SMTP Server Password
  'password' => env('MAIL_PASSWORD'),

  // Sendmail System Path

  'sendmail' => '/usr/sbin/sendmail -bs',

  // Mail "Pretend"
  'pretend' => false,

);
