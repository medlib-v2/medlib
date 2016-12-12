<?php

namespace Medlib\Commands;

use Medlib\Realtime\Events as SocketClient;

abstract class Command
{


    /**
     * @var \Medlib\Realtime\Events
     */
    private $socketClient;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->socketClient = new SocketClient;
    }
}
