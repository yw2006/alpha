<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiscountType>
 */
class DiscountTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' Discount',
            "arName"=>"اسم",
            'value' => $this->faker->randomFloat(2, 5, 20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
