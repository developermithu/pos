<?php

namespace Database\Factories;

use App\Enums\ProductType;
use App\Models\Unit;
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
        $units = Unit::whereUnitId(null)->pluck('id')->toArray();

        return [
            'ulid' => strtolower(Str::ulid()),
            'category_id' => rand(1, 3),
            'unit_id' => fake()->randomElement($units),
            'name' => fake()->words(rand(1, 4), true),
            'sku' => fake()->unique()->numberBetween(000000, 999999),
            'qty' => rand(0, 100),
            'cost' => rand(100, 500),
            'price' => rand(600, 800),
            'created_at' => now()->addMonths(rand(-1, -24)),
            'type' => fake()->randomElement([ProductType::SERVICE]),
        ];
    }
}
