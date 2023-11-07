<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\Card;
use Illuminate\Console\Command;

class UpdateCardValidity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-card-validity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cards = Card::all();

        foreach ($cards as $card) {
            $cardValidFrom = Carbon::parse($card->valid_from)->startOfDay();
            $cardValidUntil = Carbon::parse($card->valid_until)->endOfDay();
    
            $isCardValid = now()->timezone('Asia/Manila')->between($cardValidFrom, $cardValidUntil);
    
            if ($isCardValid) {
                // Card is still valid, update the status to 'Active'
                $card->update(['status' => 'Active']);
            } else {
                // Card is not valid, update the status to 'Inactive' or any other status
                $card->update(['status' => 'Expired']);
            }
        }

        //  Log::truncate();
    
        $this->info('Card statuses updated successfully.');
    }
}
