<?php

namespace App\Repositories;
use App\Message;
use App\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Debug\Debug;


class ChatRepository
{

    public static function get($c1, $c2, $limit = 15)
    {
        $messages = Message::where('receiver_id', $c1)
            ->where('sender_id', $c2)
            ->orWhere('receiver_id', $c2)
            ->where('sender_id', $c1)
            ->orderBy('created_at', 'asc')
            ->limit($limit);

        return $messages;
    }

    public static function send($senderId, $receiverId, $data)
    {
        $m = new Message();
        $m->sender_id = $senderId;
        $m->receiver_id = $receiverId;
        $m->message = $data['content'];
        $m->saveOrFail();

        return $m;
    }

    public static function getCounts($userId)
    {
        $messageCounts = User::withCount('incomingMessages')->find($userId);
        return $messageCounts;
    }


    public static function getContactsWithUnreadTotalMessages($userId)
    {

        // This is done this way 'cause Laravel doesn't support subqueries, yet.
        $sub = DB::table('messages as m')
            ->select(DB::raw('COUNT(*) as count'), 'm.sender_id', 'm.receiver_id')
            ->join('last_reads as lr', function($join){
                $join->on('lr.sender_id', 'm.sender_id')
                    ->on('lr.receiver_id', 'm.receiver_id')
                    ->on('lr.updated_at', '<', 'm.created_at');
            })
            ->groupBy('m.sender_id', 'm.receiver_id')
            ->toSql();

        return DB::table('users as r')
            ->where('r.id', $userId)
            ->join('user_groups as ug1', 'ug1.user_id', 'r.id')
            ->join('groups as g', 'g.id', 'ug1.group_id')
            ->join('user_groups as ug2', 'ug2.group_id', 'g.id')
            ->join('users as s', 's.id', 'ug2.user_id')
            ->where('s.id', '<>', $userId)
            ->leftJoin(DB::raw("($sub) as m"), function ($join) {
                $join->on('m.sender_id', 's.id')
                    ->on('m.receiver_id', 'r.id');
            })
            ->select('m.count as messagesCount', 's.id', 's.name', 's.email')
            ->get();
    }

}