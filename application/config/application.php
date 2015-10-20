<?php
return array(
  // Application Debug Mode
  'debug' => env('APPLICATION_DEBUG', false),

  // Application URL
  'url' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),

  // Application Timezone
  'timezone' => 'UTC',

  // Application Locale Configuration
  'locale' => 'en',

  // Application Fallback Locale
  'fallback_locale' => 'en',

  // Encryption Key
  'key' => env('APP_KEY', 'SomeRandomString'),
  'cipher' => 'AES-256-CBC',

  // Logging Configuration
  // Available Settings: "single", "daily", "syslog", "errorlog"
  'log' => 'single',

  // Service Providers Autoloaded
  'providers' => array(),

  // Class Aliases
  'aliases' => array(),

);
