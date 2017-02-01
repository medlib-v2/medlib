<?php

namespace Medlib\Events;

use Medlib\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\SerializesModels;

/**
 * Event which is fired when the JSON web token expires.
 */
class JsonWebTokenExpired extends Login
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user  = $user;
        //parent::__construct($this->user, null);
    }
}
