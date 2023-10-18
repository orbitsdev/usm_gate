<?php

namespace Database\Seeders;

use App\Models\CardSettings;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CardSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $card_setting = CardSettings::factory(1)->create();
    }
}
