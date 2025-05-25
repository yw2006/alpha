<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceRequest>
 */
class PriceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_notes' => $this->faker->optional()->paragraph,
            'company_id' => Company::factory(),
            'created_by' => User::factory(),
            'image' => $this->faker->optional()->imageUrl,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
