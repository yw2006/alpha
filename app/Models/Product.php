<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'title',
        'arTitle',
        'status',
        'base_price',
        'base_stock',
        'discount_price',
        'description',
        'arDescription'
    ];
    public function variants()  {
        return $this->hasMany(productVariant::class);
    }
    public function activeVariants()
    {
        return $this->variants()->where('status', true);
    }
    public function category(){
        return $this->belongsToMany(Category::class,"products_categories");
    }
    public function vendors(){
        return $this->belongsToMany(Vendor::class,"product_vendors");
    }
    
}
