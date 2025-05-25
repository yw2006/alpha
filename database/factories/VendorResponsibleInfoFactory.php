<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorResponsibleInfo>
 */
class VendorResponsibleInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => Vendor::factory(),
            'name' => $this->faker->name,
            'arName' => "اسم",
            'mobile' => $this->faker->optional()->phoneNumber,
            'whatsapp_mobile' => $this->faker->optional()->phoneNumber,
            'title' => $this->faker->optional()->jobTitle,
            'arTitle' => "لقب",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
