<?php

namespace App\Listeners;

use App\Models\Collaborate;
use Auth;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        if(Auth::user()){
            $sent = User::find(Auth::user()->id)->collaboration->all();
            $sentCount = 0;
            foreach($sent as $se){
                $sentCount += Collaborate::whereId($se->id)->count();
            }
            $received = User::find(Auth::user()->id)->creation->all();
            $receivedCount = 0;
            foreach($received as $rec){
                $receivedCount += Collaborate::whereUser_creation_id($rec->id)->count();
            }
            $value = $sentCount + $receivedCount;
            Session::put('collaborationsCount', $value);
        }
    }
}


