<?php

namespace App\Observers;

use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AccountObsever
{
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        $uuid = str_replace('-', '', Str::orderedUuid());

        // Shuffle the characters and convert to title case to ensure a combination of uppercase and lowercase characters
        $shuffledUuid = mb_convert_case(str_shuffle($uuid), MB_CASE_TITLE);

        // Ensure the shuffled UUID is exactly 12 characters long
        $shuffledUuid = str_pad(substr($shuffledUuid, 0, 12), 12, '0', STR_PAD_RIGHT);

        $account->unique_id = $shuffledUuid; // Assign the shuffled UUID to the account's unique_id

        $account->save();
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
