<?php

namespace Database\Factories;

use App\Models\PriceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceRequestRejection>
 */
class PriceRequestRejectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price_requested' => PriceRequest::factory(),
            'note' => $this->faker->paragraph,
            'status_image' => $this->faker->optional()->imageUrl,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
