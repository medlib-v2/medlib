<?php

return array(
  // PDO Fetch Style
  'fetch' => PDO::FETCH_CLASS,

  // Default Database Connection Name
  'default' => env('DB_CONNECTION', 'mysql'),

  // Database Connections
  'connections' => array(
    'mysql' => array(
      'driver'    => 'mysql',
      'host'      => env('DB_HOST', 'localhost'),
      'database'  => env('DB_DATABASE', 'medlib-dev'),
      'username'  => env('DB_USERNAME', 'root'),
      'password'  => env('DB_PASSWORD', 'root'),
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix'    => '',
      'strict'    => false,
    ),
  ),
  
);
