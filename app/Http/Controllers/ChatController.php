<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\ChatRoom;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function chat()
    {
        $user = Auth::user();
        return view('chat',compact('user'));
    }

}
