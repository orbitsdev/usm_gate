<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Card;

class CardObserver
{
    /**
     * Handle the Card "created" event.
     */
    public function created(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "updated" event.
     */
    public function updated(Card $card): void
    {
        $cardValidUntil = Carbon::parse($card->valid_until)->endOfDay();
        $isCardValid = now()->timezone('Asia/Manila')->lte($cardValidUntil);

        if($card->status == 'Active'){



            if ($isCardValid && $card->status !== 'Active') {
                // Card is still valid, update the status to 'Active'
                $card->status = 'Active';
                $card->save();
            } elseif (!$isCardValid && $card->status !== 'Expired') {
                // Card is not valid, update the status to 'Expired' or any other status
                $card->status = 'Expired';
                $card->save();
            }
        }

    }

    /**
     * Handle the Card "deleted" event.
     */
    public function deleted(Card $card): void
    {
        $card->records()->delete();
        $card->transactions()->delete();
    }

    /**
     * Handle the Card "restored" event.
     */
    public function restored(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "force deleted" event.
     */
    public function forceDeleted(Card $card): void
    {
        //
    }
}
