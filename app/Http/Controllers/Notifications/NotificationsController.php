<?php

namespace Medlib\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;

class NotificationsController extends Controller
{


    public function notifications()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return view('notifications.show')->with('notifications', Auth::user()->notifications);
    }

    public function unread()
    {
        return Auth::user()->unreadNotifications;
    }
}
