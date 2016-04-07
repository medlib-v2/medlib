<?php

namespace Medlib\Http\Controllers\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
     */
    public function __construct() {

        $this->middleware('auth');
        $this->currentUser = Auth::user();
    }

    /**
     * Display the specified user.
     *
     * @param FeedRepository $feedRepository
     * @return View
     */
    public function index(FeedRepository $feedRepository) {

        $currentUser = $this->currentUser;

        $user = User::find($currentUser->id);

        return $this->showFriendsAndFeeds($user, $feedRepository, $currentUser);
    }

    /**
     * Display the specified user.
     *
     * @param $username
     * @param UserRepository $userRepository
     * @param FeedRepository $feedRepository
     * @return View
     */
    public function show($username, UserRepository $userRepository, FeedRepository $feedRepository) {

        $currentUser = $this->currentUser;

        $user = $userRepository->findByUsername($username);

        if (!$user == null) {

            return $this->showFriendsAndFeeds($user, $feedRepository, $currentUser);
        }

        return Redirect::back()->withErrors("User does not exist $username");


    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @param FeedRepository $feedRepository
     * @param $currentUser
     * @return View
     */
    private function showFriendsAndFeeds(User $user, FeedRepository $feedRepository, $currentUser) {

        $friends = $user->friends()->take(8)->get();

        $feeds = $feedRepository->getPublishedByUser($user);

        return view('users.users.show', compact('currentUser', 'user', 'friends', 'feeds'));

    }

}