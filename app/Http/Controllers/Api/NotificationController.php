<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }
    public function get(){

        $unreadNotifications = Auth::user()->unreadNotifications;
        $fechaActual = date('Y-m-d');

        foreach ($unreadNotifications as $notification) {
            if ($fechaActual != $notification->created_at->toDateString()) {
                $notification->markAsRead();
            }
        }
        return Auth::user()->unreadNotifications;
    }
}
