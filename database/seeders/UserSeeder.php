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
        User::create([
            'name'=> 'Admin User',
            'email'=> 'admin@gmail.com',
            'password'=> Hash::make('password')
        ]);
        User::create([
            'name'=> 'Developer User',
            'email'=> 'developer@gmail.com',
            'password'=> Hash::make('password')
        ]);
    }
}
