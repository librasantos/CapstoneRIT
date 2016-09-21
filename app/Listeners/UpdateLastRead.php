<?php

namespace App\Listeners;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\LastRead;
use Faker\Provider\zh_TW\DateTime;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLastRead
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
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageRead $event)
    {
        $lastread = LastRead::where('receiver_id', $event->receiverId)
            ->where('sender_id', $event->senderId)
            ->first();

        // If exists updated, if not exists created new object and save it.
        if($lastread){
            $lastread->updated_at = new \DateTime();
            $lastread->save();
        } else {
            $lastread = new LastRead();
            $lastread->sender_id = $event->senderId;
            $lastread->receiver_id = $event->receiverId;
            $lastread->save();
        }

    }
}
