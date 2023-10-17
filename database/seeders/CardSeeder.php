<?php

namespace Database\Seeders;

use App\Models\Card;
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
       
$accounts = Account::whereDoesntHave('card')->get();

foreach ($accounts as $account) {
    Card::factory()->create(['account_id' => $account->id]);
}
    }
}
