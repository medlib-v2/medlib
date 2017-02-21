<?php

namespace Medlib\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use Medlib\Events\NotificationRead;
use Illuminate\Support\Facades\Auth;
use Medlib\Events\NotificationReadAll;
use Medlib\Http\Controllers\Controller;
use Medlib\Notifications\HelloNotification;
use Medlib\Notifications\SendFriendRequestAlertEmail;
use Medlib\Notifications\SendConfirmationRequestAccepted;
use NotificationChannels\WebPush\PushSubscription;

class NotificationsController extends Controller
{

    public function index()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return view('notifications.show')->with('notifications', Auth::user()->notifications);
    }

    /**
     * Get user's notifications.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function unread(Request $request)
    {
        $user = $request->user();

        /**
         * Limit the number of returned notifications, or return all
         */
        $query = $user->unreadNotifications();
        $limit = (int) $request->input('limit', 0);
        if ($limit) {
            $query = $query->limit($limit);
        }
        $notifications = $query->get()->each(function ($notification) {
            $notification->created = $notification->created_at->toIso8601String();
        });
        $total = $user->unreadNotifications->count();

        return compact('notifications', 'total');
    }

    /**
     * Create a new notification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->notify(new HelloNotification);
        return response()->json('Notification sent.', 201);
    }

    /**
     * Mark user's notification as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()
            ->unreadNotifications()
            ->where('id', $id)
            ->first();
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }
        $notification->markAsRead();
        event(new NotificationRead($request->user()->id, $id));
    }

    /**
     * Mark all user's notifications as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function markAllRead(Request $request)
    {
        $request->user()
            ->unreadNotifications()
            ->get()->each(function ($n) {
                $n->markAsRead();
            });
        event(new NotificationReadAll($request->user()->id));
    }

    /**
     * Get user's last notification from database.
     *
     * This method will be accessed by the service worker
     * so the user is not authenticated and it requires an endpoint.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function last(Request $request)
    {
        if (empty($request->endpoint)) {
            return response()->json('Endpoint missing.', 403);
        }
        $subscription = PushSubscription::findByEndpoint($request->endpoint);
        if (is_null($subscription)) {
            return response()->json('Subscription not found.', 404);
        }
        $notification = $subscription->user->unreadNotifications()->first();
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }
        return $this->payload($notification);
    }

    /**
     * Mark the notification as read and dismiss it from other devices.
     *
     * This method will be accessed by the service worker
     * so the user is not authenticated and it requires an endpoint.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function dismiss(Request $request, $id)
    {
        if (empty($request->endpoint)) {
            return response()->json('Endpoint missing.', 403);
        }
        $subscription = PushSubscription::findByEndpoint($request->endpoint);
        if (is_null($subscription)) {
            return response()->json('Subscription not found.', 404);
        }
        $notification = $subscription->user->notifications()->where('id', $id)->first();
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }
        $notification->markAsRead();
        event(new NotificationRead($subscription->user->id, $id));
    }
    /**
     * Get the payload for the given notification.
     *
     * @param  \Illuminate\Notifications\DatabaseNotification $notification
     * @return string
     */
    protected function payload($notification)
    {
        $payload = [
            'title' => isset($notification->intro[0]) ? $notification->intro[0] : null,
            'body' => $this->format($notification),
            'actionText' => $notification->action_text ?: null,
            'actionUrl' => $notification->action_url ?: null,
            'id' => isset($notification->id) ? $notification->id : null,
        ];
        return json_encode($payload);
    }
    /**
     * Format the given notification.
     *
     * @param  \Illuminate\Notifications\DatabaseNotification $notification
     * @return string
     */
    protected function format($notification)
    {
        $message = trim(implode(PHP_EOL.PHP_EOL, $notification->intro));
        $message .= PHP_EOL.PHP_EOL.trim(implode(PHP_EOL.PHP_EOL, $notification->outro));
        return trim($message);
    }

    public function notifications()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return Auth::user()->notifications;
    }
}
