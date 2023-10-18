<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Record;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
// $accounts = Account::whereDoesntHave('card')->get();

// foreach ($accounts as $account) {
//     Card::factory()->create(['account_id' => $account->id]);


// }

$accounts = Account::whereDoesntHave('card')->get();

        foreach ($accounts as $account) {
            $card = Card::factory()->create(['account_id' => $account->id]);

            // Create a random number of records between 1 and 3 for each card
            $numberOfRecords = rand(1, 3);

            for ($i = 0; $i < $numberOfRecords; $i++) {
                $card->records()->save(Record::factory()->create());
            }
        }

    }
}
