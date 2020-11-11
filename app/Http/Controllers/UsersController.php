<?php

namespace App\Http\Controllers;

class UsersController extends Controller
{
    public function notifications()
    {
        //mark all notifications as read
        auth()->user()->unreadNotifications->markAsRead();

        return view('users.notifications',[
           'notifications' => auth()->user()->notifications()->paginate( 2 )
        ]);
    }
}
