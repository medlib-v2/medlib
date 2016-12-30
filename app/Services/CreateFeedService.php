<?php

namespace Medlib\Services;

use Medlib\Models\Feed;
use Medlib\Services\Service;
use Illuminate\Support\Facades\Auth;

class CreateFeedService extends Service
{

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $poster_username;

    /**
     * @var string
     */
    protected $poster_profile_image;

    /**
     * Create a new command instance.
     *
     * @param string $body
     * @param string $poster_username
     * @param string $poster_profile_image
     */
    public function __construct($body, $poster_username, $poster_profile_image)
    {
        $this->body = $body;
        $this->poster_username = $poster_username;
        $this->poster_profile_image = $poster_profile_image;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $feed = Feed::publish($this->body, $this->poster_username, $this->poster_profile_image);
        Auth::user()->feeds()->save($feed);
        return $feed;
    }
}
