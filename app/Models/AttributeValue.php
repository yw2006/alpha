<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    /** @use HasFactory<\Database\Factories\AttributeValueFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
"name",
"arName",
"attribute_id"
    ];
    protected $hidden = [
        "deleted_at","pivot"
    ];
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function variants(){
    return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute_values', 
    'attribute_value_id','product_variant_id')
                ->withTimestamps();
}

}
