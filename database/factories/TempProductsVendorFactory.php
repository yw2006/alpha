<?php

namespace Database\Factories;

use App\Models\TempProduct;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TempProductsVendor>
 */
class TempProductsVendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'temp_product_id' => TempProduct::factory(),
            'vendor_id' => Vendor::factory(),
        ];
    }
}
