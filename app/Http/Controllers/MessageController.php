<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller
{

    public function getConversationWith ($contactId)
    {
//        $user = Auth::user();

        $messages = ChatRepository::get(1, $contactId)->get();
        return $messages;
    }

    public function sendTo(Request $request, $receiverId)
    {
//        $user = Auth::user();
        $m = ChatRepository::send(1, $receiverId, $request->all());
        broadcast(new MessageSent($m));
        return [];
    }
}
