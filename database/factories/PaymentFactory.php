<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'payment_type' => $this->faker->randomElement(['cash', 'deferred']),
            'payment_status' => $this->faker->randomElement(['0', '1', '2', '3']),
            'amount_paid' => $this->faker->randomFloat(2, 0, 1000),
            'remain_amount' => $this->faker->randomFloat(2, 0, 500),
            'notes' => $this->faker->optional()->sentence(),
            'paid_at' => $this->faker->optional()->dateTimeThisMonth(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
