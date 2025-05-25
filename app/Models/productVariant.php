<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'status',
        'price',
        'stock',
        'image',
    ];
    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_variant_attribute_values',
            'product_variant_id',
            'attribute_value_id'
        )->withTimestamps();
    }
    
}
