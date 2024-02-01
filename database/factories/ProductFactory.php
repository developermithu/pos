<?php

namespace Database\Factories;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => rand(1, 3),
            'unit_id' => rand(1, 3),
            'name' => fake()->words(rand(1, 4), true),
            'sku' => fake()->unique()->numberBetween(000000, 999999),
            'qty' => rand(0, 100),
            'cost' => rand(0, 100),
            'price' => rand(500, 1000),
            'created_at' => now()->addMonths(rand(-1, -24)),
            'type' => fake()->randomElement([ProductType::SERVICE])
        ];
    }
}
