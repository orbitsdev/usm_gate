<?php

namespace App\Events;

use App\Models\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LogCreation implements ShouldBroadcast
{
use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public Log $log;

    public function __construct(Log $log)
    {
        $this->log = $log;

    }

    public function broadcastOn()
    {
        return new Channel('log');

        
    }
    

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return array<int, \Illuminate\Broadcasting\Channel>
    //  */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('channel-name'),
    //     ];
    // }
}
