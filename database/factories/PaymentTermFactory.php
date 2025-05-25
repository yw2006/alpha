<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentTerm>
 */
class PaymentTermFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'arName' => $this->faker->word,
            'kind' => $this->faker->randomElement(['net', 'cod', 'prepaid']),
            'arkind' => "عربي :".$this->faker->randomElement(['net', 'cod', 'prepaid']),
            'period' => $this->faker->word,
            'arPeriod' => "عربي:".$this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
