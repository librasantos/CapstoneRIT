<?php

namespace App\Events;

use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $receiverId;
    public $content;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $m)
    {
        $this->receiverId = $m->receiverId;
        $this->content = $m->content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return 'message.' . $this->receiverId;
//        return 'message.' . $this->receiverId;
//        return new PrivateChannel('message.'.$this->receiverId);
    }
}
