<?php

namespace Medlib\Services;

use Medlib\RealTime\Events as SocketClient;

abstract class Service
{

    /**
     * @var \Medlib\RealTime\Events
     */
    protected $client;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->client = new SocketClient;
    }
}
