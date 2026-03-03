<?php

namespace Database\Factories;

use App\Models\Category;
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
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price_sale' => fake()->randomFloat(2, 5, 500),
            'product_code' => strtoupper(fake()->unique()->bothify('PRD-####')),
            'status' => true,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => Category::query()->create([
                'name' => fake()->unique()->word(),
                'icon' => 'Flower2',
                'sort_order' => fake()->numberBetween(0, 100),
            ])->id,
        ];
    }
}
