<?php

namespace Medlib\Services;

use Medlib\Models\User;
use Medlib\Models\Notification;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Medlib\Events\FriendRequestWasAccepted;
use Medlib\Http\Requests\FriendUserRequest;
use Medlib\Repositories\User\UserRepository;

class FriendRequestAcceptedService extends Service
{
    /**
     *  @var string
     */
    protected $requestedName;

    /**
     * @var \Medlib\Models\User;
     */
    private $currentUser;

    private $notificationId;

    /**
     * Create a new command instance.
     * @param FriendUserRequest $request
     *
     */
    public function __construct(FriendUserRequest $request)
    {
        parent::__construct();
        $this->requestedName = $request->get('username');
        $this->notificationId = $request->has('not_id') ? $request->get('not_id') : null;
        $this->currentUser = Auth::user();
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $repository
     * @return boolean
     */
    public function handle(UserRepository $repository)
    {
        $friend = User::whereUsername($this->requestedName)->first();

        $isFriend = $friend->isFriendsWith($this->currentUser->id);

        if (!$isFriend) {
            $this->currentUser->createFriendShipWith($friend->id);

            $repository->findByUsername($friend->getUsername())->createFriendShipWith($this->currentUser->id);

            FriendRequest::where('user_id', $this->currentUser->id)->where('requester_id', $friend->id)->delete();

            if ($this->notificationId) {
                $notification = Notification::find($this->notificationId);
                $notification->readAt();
            }
            event(new FriendRequestWasAccepted($this->currentUser, $friend));
        }
        return $this->currentUser->friendRequests()->count();
    }
}
