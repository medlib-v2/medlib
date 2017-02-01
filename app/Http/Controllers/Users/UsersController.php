<?php

namespace Medlib\Http\Controllers\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Medlib\Http\Controllers\Controller;
use Medlib\Models\User;
use Medlib\Repositories\Feed\FeedRepository;
use Medlib\Repositories\User\UserRepository;

class UsersController extends Controller
{

    /**
     * @var \Illuminate\Support\Facades\Auth
     */
    private $currentUser;

    /**
     * Display the specified user.
     *
     * @param FeedRepository $feedRepository
     * @return View
     */
    public function index(FeedRepository $feedRepository)
    {
        $this->currentUser = Auth::user();

        $user = User::find($this->currentUser->id);

        return $this->showFriendsAndFeeds($user, $feedRepository, $this->currentUser);
    }

    /**
     * Display the specified user.
     *
     * @param $username
     * @param UserRepository $userRepository
     * @param FeedRepository $feedRepository
     * @return View
     */
    public function show($username, UserRepository $userRepository, FeedRepository $feedRepository)
    {
        $this->currentUser = Auth::user();

        if ($this->currentUser->getUsername() == $username) {
            $user = User::find($this->currentUser->id);

            return $this->showFriendsAndFeeds($user, $feedRepository, $this->currentUser);
        } else {
            $user = $userRepository->findByUsername($username);

            if (!$user == null) {
                return $this->showFriendsAndFeeds($user, $feedRepository, $this->currentUser);
            }

            return Redirect::back()->withErrors("User does not exist $username");
        }
    }

    /**
     * @param $username
     * @return mixed
     */
    public function me($username)
    {
        if (Auth::user()->getUsername() == $username) {
            return $this->response(Auth::user());
        }
        return $this->setStatusCode(401)->response(['response' => 'Unauthorized.']);
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @param FeedRepository $feedRepository
     * @param $currentUser
     * @return View
     */
    private function showFriendsAndFeeds(User $user, FeedRepository $feedRepository, $currentUser)
    {
        $friends = $user->friends()->take(8)->get();

        $feeds = $feedRepository->getPublishedByUserAndFriends($user);

        return view('users.users.show', compact('currentUser', 'user', 'friends', 'feeds'));
    }
}
