<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;



class NotificationController extends Controller
{

    public function read($id)
    {
        $notificacion = auth()->user()->notifications()->where('id',$id)->first();

        $notificacion->markAsRead();

        return redirect($notificacion->data['url']);
    }

    public function readall()
    {
        $notificaciones = auth()->user()->notifications()->get();

        $notificaciones->markAsRead();

        return back();
    }
}
