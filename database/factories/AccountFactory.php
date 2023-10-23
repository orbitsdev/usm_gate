<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $contactNumber =  $this->faker->numberBetween(9000000000, 9999999999);

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->firstName(), // Use middleName method
            'address' => $this->faker->address(), // Use middleName method
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'birth_date' => $this->faker->date(),
            'contact_number' => $contactNumber,
            'account_type' => $this->faker->randomElement(['Student', 'Teacher']),
            // 'image' => $this->faker->imageUrl(),
        ];
    }
}
