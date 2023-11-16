<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'supplier_id' => rand(1, 50),
            'name' => fake()->words(rand(1, 4), true),
            'sku' => 'SKU-' . fake()->unique()->numberBetween(000000, 999999),
            'qty' => rand(50, 100),
            'buying_date' => now()->addDays(rand(-5, -30)),
            'expired_date' => now()->addMonths(rand(6, 24)),
            'buying_price' => rand(500, 1000),
            'selling_price' => rand(1500, 2000)
        ];
    }
}
