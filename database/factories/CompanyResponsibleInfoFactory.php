<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyResponsibleInfo>
 */
class CompanyResponsibleInfoFactory extends Factory
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
            'name' => $this->faker->name,
            "arName"=>"اسم",
            'mobile' => $this->faker->phoneNumber,
            'whatsapp_mobile' => $this->faker->phoneNumber,
            'title' => $this->faker->jobTitle,
            "arTitle"=>"لقب",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
