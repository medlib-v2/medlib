<?php

return array(
  // Default Filesystem Disk
  // Supported: "local", "ftp"

  'default' => 'local',

  // Filesystem Disks
  'disks' => array(
    'local' => array(
        'driver' => 'local',
        'root'   => storage_path('app'),
    ),
    'ftp' => array(
        'driver'   => 'ftp',
        'host'     => 'ftp.medlib.fr',
        'username' => 'username',
        'password' => 'password',

        // Optional FTP Settings...
        'port'     => 21,
        //'root'     => '',
        'passive'  => true,
        //'ssl'      => true,
        //'timeout'  => 30,
    ),
  ),
);
