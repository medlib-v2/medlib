<?php

namespace Medlib;


use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTManager;
use Tymon\JWTAuth\JWTAuth as BaseJWTAuth;
use Tymon\JWTAuth\Providers\Auth\AuthInterface;
use Tymon\JWTAuth\Providers\User\UserInterface;

class JWTAuth extends BaseJWTAuth
{
    /**
     * JWTAuth constructor.
     * {@inheritdoc}
     *
     * @param \Tymon\JWTAuth\JWTManager                   $manager
     * @param \Tymon\JWTAuth\Providers\User\UserInterface $user
     * @param \Tymon\JWTAuth\Providers\Auth\AuthInterface $auth
     * @param \Illuminate\Http\Request                    $request
     */
    public function __construct(JWTManager $manager, UserInterface $user, AuthInterface $auth, Request $request)
    {
        return parent::__construct($manager, $user, $auth, $request);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $method
     * @param string $header
     * @param string $query
     *
     * @return \Tymon\JWTAuth\JWTAuth
     */
    public function parseToken($method = 'bearer', $header = 'authorization', $query = 'jwt-token')
    {
        return parent::parseToken($method, $header, $query);
    }
}