<?php

namespace Medlib\Http\Controllers\Users;

use Medlib\Models\User;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Medlib\Repositories\User\UserRepository;
use Illuminate\Http\Response as IlluminateResponse;

class UsersController extends Controller
{

    /**
     * @var \Medlib\Models\User
     */
    private $currentUser;

    /**
     * Display the specified user.
     *
     * @param $username
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($username, UserRepository $userRepository)
    {
        $this->currentUser = Auth::user();

        if ($this->currentUser->getUsername() == $username) {
            return $this->showFriendsAndFeeds($this->currentUser);
        } else {
            $user = $userRepository->findByUsername($username);
            if (!$user == null) {
                return $this->showFriendsAndFeeds($user);
            }
            return $this->responseWithError(['message' => "User does not exist $username"], IlluminateResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified user.
     *
     * @param $username
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($username, UserRepository $userRepository)
    {
        $this->currentUser = Auth::user();

        if ($this->currentUser->getUsername() == $username) {
            $user = $this->currentUser;

            return $this->showFriendsAndFeeds($user);
        } else {
            $user = $userRepository->findByUsername($username);

            if (!$user == null) {
                return $this->showFriendsAndFeeds($user);
            }

            return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->responseWithError(['message' => "User does not exist $username"]);
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
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->responseWithError(['response' => 'Unauthorized.']);
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    private function showFriendsAndFeeds(User $user)
    {
        $friends = $user->friends()->take(8)->get();
        return $this->response([
            compact('user', 'friends')
        ]);
        //return view('users.users.show', compact('user', 'friends'));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function followUser($username)
    {
        $user = User::whereUsername($username)->first();

        Auth::user()->followUser($user);

        Session::flash('success', 'You have followed this user!');
        return redirect()->back();
    }

    /**
     * @param $username
     * @return mixed
     */
    public function unfollowUser($username)
    {
        $user = User::whereUsername($username)->first();

        Auth::user()->unfollowUser($user);

        Session::flash('success', 'You have unfollowed this user!');
        return redirect()->back();
    }
}
