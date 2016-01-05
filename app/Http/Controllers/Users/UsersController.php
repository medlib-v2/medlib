<?php

namespace Medlib\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Medlib\Http\Controllers\Controller;
use Medlib\Models\User;
use Medlib\Repositories\Feed\FeedRepository;
use Medlib\Repositories\User\UserRepository;

class UsersController extends Controller {

    /**
     * @var \Illuminate\Support\Facades\Auth
     */
    private $currentUser;

    /**
     * Create a new instance of UsersController
     *
     * @param Object $userRepository
     *
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->currentUser = Auth::user();
    }

    public function index() {
        return view('users.users.profile');
    }


    /**
     * Display the specified user.
     *
     * @param  int $username
     *
     * @return View
     */
    public function show($username, UserRepository $userRepository, FeedRepository $feedRepository) {

        $currentUser = $this->currentUser;

        $user = $userRepository->findByUsername($username);

        $friends = $user->friends()->take(8)->get();

        $feeds = $feedRepository->getPublishedByUser($user);

        return view('users.users.show', compact('currentUser', 'user', 'friends', 'feeds'));

    }

}