<?php

namespace Database\Factories;

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
            'title' => $this->faker->words(3, true),
            "arTitle"=>"لقب",
            'base_price' => $this->faker->randomFloat(2, 10, 1000),
            'base_stock' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->optional()->paragraph,
            "arDescription"=>"وصف",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
