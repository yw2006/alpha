<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DayCollect>
 */
class DayCollectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'collected_at' => $this->faker->dateTimeBetween('-1 year', 'now'), 
            'paid_amount' => $this->faker->randomFloat(2, 0, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
