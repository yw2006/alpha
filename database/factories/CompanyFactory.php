<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\DiscountType;
use App\Models\PaymentTerm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
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
            'arName' => 'شركة ' . $this->faker->word, // Arabic example
            'address' => $this->faker->optional()->address,
            'arAddress' => 'العنوان: ' . $this->faker->streetAddress, // Arabic address
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->optional()->phoneNumber,
            'location' => $this->faker->optional()->city,
            'industry' => $this->faker->randomElement(['retail', 'manufacturing', 'services', 'technology', 'healthcare', 'other']),
            "arIndustry"=>"المجال",
            'commercial_registration_number' => $this->faker->optional()->numerify('CRN-######'),
            'commercial_registration_image' => $this->faker->optional()->imageUrl,
            'tax_id' => $this->faker->optional()->numerify('TAX-######'),
            'tax_image' => $this->faker->optional()->imageUrl,
            'image' => $this->faker->optional()->imageUrl,
            'city_id' => City::factory(),
            'discount_type_id' => DiscountType::factory(),
            'payment_term_id' => PaymentTerm::factory(), // Add this in migration too!
            'created_by' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
