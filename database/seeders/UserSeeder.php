<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $adminUser = User::where('email', 'admin@gmail.com')->first();

    // If admin user doesn't exist, create it
    if (!$adminUser) {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);
    }

    // Check if developer user exists
    $developerUser = User::where('email', 'developer@gmail.com')->first();

    // If developer user doesn't exist, create it
    if (!$developerUser) {
        User::create([
            'name' => 'Developer User',
            'email' => 'developer@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
    }
}
