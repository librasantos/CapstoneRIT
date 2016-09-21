<?php

namespace App\Http\Controllers;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Repositories\ChatRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function getConversationWith ($contactId)
    {
        $user = Auth::guard('api')->user();

        $messages = ChatRepository::get($user->id, $contactId)->get();
        // Broadcast MessageRead event
        event(new MessageRead($user->id, $contactId));
        return $messages;
    }

    public function getMessageCounts()
    {
        $user = Auth::guard('api')->user();
        return ChatRepository::getCounts($user->id);
    }

    public function sendTo(Request $request, $receiverId)
    {
        $user = Auth::guard('api')->user();
        $m = ChatRepository::send($user->id, $receiverId, $request->json('message'));
        broadcast(new MessageSent($m));
        return $m;
    }
}
