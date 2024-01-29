<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'father_name' => fake()->name('male'),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'basic_salary' => fake()->randomFloat(2, 5000, 10000),
            'old_basic_salary' => null,
            'salary_updated_at' => null,
            'joined_at' => now()->addDays(rand(-30, -10)),
            'gender' => fake()->randomElement(['male', 'female']),
        ];
    }
}
