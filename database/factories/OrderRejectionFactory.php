<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderRejection>
 */
class OrderRejectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'note' => $this->faker->paragraph,
            'image' => $this->faker->optional()->imageUrl,
            'created_by' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
