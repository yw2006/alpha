<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\ProductVariantAttributeValue;
use App\Models\AttributeValue; // ✅ Correct model here
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariantAttributeValue>
 */
class ProductVariantAttributeValueFactory extends Factory
{
    protected $usedCombinations = [];

    public function definition(): array
    {
        do {
            $productVariantId = ProductVariant::inRandomOrder()->value('id') ?? ProductVariant::factory()->create()->id;
            $attributeValueId = AttributeValue::inRandomOrder()->value('id') ?? AttributeValue::factory()->create()->id;

            $combinationKey = $productVariantId . '-' . $attributeValueId;
        } while (in_array($combinationKey, $this->usedCombinations));

        $this->usedCombinations[] = $combinationKey;

        return [
            'product_variant_id' => $productVariantId,
            'attribute_value_id' => $attributeValueId,
        ];
    }
}
