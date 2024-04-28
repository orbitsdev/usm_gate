<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\CardSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RecordSeeder;
use Database\Seeders\AccountSeeder;
use Database\Seeders\PurposeSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CardSettingsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UserSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(DaySeeder::class); // Move DaySeeder before CardSeeder
        $this->call(PurposeSeeder::class); // Move PurposeSeeder before CardSeeder
        $this->call(CardSettingsSeeder::class);
        $this->call(CardSeeder::class);
        $this->call(AccountTypeSeeder::class);
        // $this->call(RecordSeeder::class);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
