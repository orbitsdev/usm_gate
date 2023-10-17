<?php

namespace App\Observers;

use App\Models\Account;
use Illuminate\Support\Facades\Storage;

class AccountObsever
{
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "updated" event.
     */
    public function updated(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        if(!empty($account->image)){

            if(Storage::disk('public')->exists($account->image)){
                Storage::disk('public')->delete($account->image);
            }
        }
    }

    /**
     * Handle the Account "restored" event.
     */
    public function restored(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "force deleted" event.
     */
    public function forceDeleted(Account $account): void
    {
        //
    }
}
