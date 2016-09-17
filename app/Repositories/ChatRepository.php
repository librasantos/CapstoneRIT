<?php

namespace App\Repositories;
use App\Message;
use App\User;

/**
 * Created by PhpStorm.
 * User: jrszapata
 * Date: 9/12/16
 * Time: 3:44 PM
 */

class ChatRepository
{

    public static function get($c1, $c2, $limit = 15) {
        return Message::whereIn('receiver_id', [$c1, $c2])
                ->whereIn('sender_id', [$c1, $c2])
                ->orderBy('created_at', 'desc')
                ->limit($limit);
    }

    public static function send($senderId, $data, $receiverId)
    {
        $m = new Message();
        $m->sender_id = $senderId;
        $m->receiver_id = $receiverId;
        $m->content = $data['content'];

        $m->saveOrFail();

        return $m;
    }

}