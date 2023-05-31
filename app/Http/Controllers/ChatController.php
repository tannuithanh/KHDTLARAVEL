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
//     public function storeRoom(Request $request)
//     {
//         $chat_room = new ChatRoom;
//         $chat_room->name = $request->name;
//         $chat_room->save();
    
//         return redirect()->route('chat'); // Sửa lại ở đây
//     }
//     public function createRoom()
//  {
//      return view('chat_rooms.create');
//  }
    
//     public function indexMessages(ChatRoom $chat_room)
//     {
//         return response()->json($chat_room->messages, 200);
//     }
    
//     public function storeMessage(Request $request, ChatRoom $chat_room)
//     {
//         $message = new Message;
//         $message->user_id = $request->user_id;
//         $message->content = $request->content;
//         $message->chat_room_id = $chat_room->id;
//         $message->save();

//         return response()->json($message, 201);
//     }
//     public function indexRooms()
//     {
//         $chat_rooms = ChatRoom::all();
//         return view('chat_rooms.index', compact('chat_rooms'));
//     }
    
}
