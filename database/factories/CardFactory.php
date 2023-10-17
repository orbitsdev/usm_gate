<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::inRandomOrder()->first(),
            'id_number' => $this->faker->unique()->randomNumber(8),
            'valid_from' => now(),  // Set to the current date
            'valid_until' => now()->addYear(),  // Set to the date one year from now
            'status' => 'active',
        ];
    }
}
