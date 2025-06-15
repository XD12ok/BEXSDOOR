<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

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
    protected $model = \App\Models\Product::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'price' => rand(2000000, 3000000),
            'views' => rand(0, 1000),
            'sales' => rand(0, 500),
            'created_at' => now()->subDays(rand(0, 30)),
            'color' => rand(0, 10),
        ];
    }
}
