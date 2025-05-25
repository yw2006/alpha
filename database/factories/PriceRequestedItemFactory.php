<?php

namespace Database\Factories;

use App\Models\PriceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceRequestedItem>
 */
class PriceRequestedItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brief' => $this->faker->optional()->paragraph,
            'image_1' => $this->faker->optional()->imageUrl,
            'image_2' => $this->faker->optional()->imageUrl,
            'image_3' => $this->faker->optional()->imageUrl,
            'image_4' => $this->faker->optional()->imageUrl,
            'image_5' => $this->faker->optional()->imageUrl,
            'price_requested' => PriceRequest::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
