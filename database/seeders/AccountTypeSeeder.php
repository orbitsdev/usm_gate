<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account_types = [
            'Student',
            'Staff',
            'Guest',
        ];

        foreach($account_types as $type){
            AccountType::create(['name'=> $type]);
        }

    }
}
