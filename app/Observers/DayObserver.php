<?php

namespace App\Observers;

use App\Models\Day;

class DayObserver
{
    /**
     * Handle the Day "created" event.
     */
    public function created(Day $day): void
    {
        //
    }

    /**
     * Handle the Day "updated" event.
     */
    public function updated(Day $day): void
    {
        //
    }

    /**
     * Handle the Day "deleted" event.
     */
    public function deleted(Day $day): void
    {
        $day->records()->delete();
    }

    /**
     * Handle the Day "restored" event.
     */
    public function restored(Day $day): void
    {
        //
    }

    /**
     * Handle the Day "force deleted" event.
     */
    public function forceDeleted(Day $day): void
    {
        //
    }
}
