<?php

namespace App\Console;

use App\Models\Day;
use App\Models\Log;
use App\Models\Transaction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {

            Transaction::truncate();
            // Log::truncate();


            // $dayRecord = Day::latest()->first();
            // if($dayRecord){
                
            //     Day::whereHas('records', function($query) use($dayRecord){
            //         $query->where('day_record_id', $dayRecord->id);
            //     })->where('exit', 'Not Logout')->update(['status' => 'Logged out']);
            //     info("Updated  rows");
            // }
        })
        ->everyTenSeconds();        
        // ->daily()->at('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
