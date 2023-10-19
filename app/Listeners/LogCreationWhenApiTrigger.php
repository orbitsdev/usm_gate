<?php

namespace App\Listeners;

use App\Models\Log;
use App\Events\LogCreation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogCreationWhenApiTrigger
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LogCreation $event): void
    {
        $event->log;

        $eventLog= Log::create([
            'card_id' => 2,
            'source' => 'form evet',
            'transaction' => 'test',
            'error_type' => 'sd',
            'message' => '',
        ]);

        
        
        
    }
}
