<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            "arName"=>"اسم",
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'phone' => $this->faker->optional()->phoneNumber,
            'address' => $this->faker->optional()->address,
            "arAddress"=>"عنوان",
            'image_url' => $this->faker->optional()->imageUrl,
            'monthly_target' => $this->faker->optional()->randomFloat(2, 1000, 10000),
            'advised_by' => User::inRandomOrder()->first()?->id,
            'role_id' => Role::factory(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
