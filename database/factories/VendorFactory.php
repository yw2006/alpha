<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            "arName"=>"اسم",
            'industry' => $this->faker->optional()->word,
            "arIndustry"=>"المجال",
            'phone' => $this->faker->optional()->phoneNumber,
            'address' => $this->faker->optional()->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
