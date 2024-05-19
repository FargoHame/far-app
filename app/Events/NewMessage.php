<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $application_id;

    public $message;

    public $user_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($application_id, $message, $user_id)
    {
        $this->message = $message;

        $this->application_id = $application_id;

        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('messages'.$this->application_id);
    }

    public function broadcastAs()
    {
        return 'NewMessage';
    }
}
