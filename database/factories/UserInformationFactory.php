<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInformation>
 */
class UserInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\UserInformation::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'role' => 'user', // Default role
            'status' => 'active',
            'contact_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'user_accounts_id' => 1, // Ensure this is replaced dynamically in your seeder
        ];
    }
}
