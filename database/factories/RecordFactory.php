<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\Purpose;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day_id' => Day::inRandomOrder()->first()->id,
            'purpose_id' => Purpose::inRandomOrder()->first()->id,
            'doord_id' => $this->faker->ipv4,
            'entry' =>$this->faker->randomElement(['Left', 'Right']),
            'exit' =>$this->faker->randomElement(['Left', 'Right'])
    
        ];
    }
}
