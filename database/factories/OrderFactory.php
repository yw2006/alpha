<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'collected_by' => User::inRandomOrder()->first()?->id,
            'created_by' => User::factory(),
            'delivered_by' => User::inRandomOrder()->first()?->id,
            'tax' => $this->faker->optional()->randomFloat(2, 0, 100),
            'order_date' => $this->faker->date(),
            'order_status' => $this->faker->randomElement([1,2,3,4,5,6]),
            'additional_tax' => $this->faker->optional()->randomFloat(2, 0, 50),
            'delivery_date' => $this->faker->optional()->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
