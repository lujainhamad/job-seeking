<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chat;

    /**
     * Create a new event instance.
     */
    public function __construct($bid)
    {
        $this->chat = $bid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $me = Auth::id();
        $other = $me != $this->chat->sender_id ? $this->chat->sender_id : $this->chat->receiver_id;
        return [
            'chat_' . $other,            
            'chat_' . $me,

        ];
    }

    public function broadcastWith()
    {
        return ['chat' => $this->chat];
    }

    public function broadcastAs()
    {
        return 'message-event';
    }
}
