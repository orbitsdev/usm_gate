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



    public function __construct(public Log $log)
    {


    }


    public function broadcastOn(): array
    {
        return [
            new Channel('log'),
        ];
    }

    public function broadcastWith(): array
{
    return ['id' => $this->log->id];
}
    
//     public function broadcastAs(): string
// {
//     return 'card.scanned';
// }
//     public function broadcastOn(): array
//     {
//         return [
//             new Channel('log.'.$this->log->id),
//         ];
//     }
    
    // public function broadcastWith () {
    //     return [
    //         'id'       => $this->log->id,
            
    //     ];
    // }
    

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
