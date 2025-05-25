<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'name',
        'arName',
        'industry',
        'arIndustry',
        'phone',
        'address',
        "status"
    ];
    protected $hidden = [
        "deleted_at"
    ];
    public function responsibleInfos()  {
        return $this->hasOne(VendorResponsibleInfo::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class,"product_vendors");
    }
    public function temp_products(){
        return $this->belongsToMany(TempProduct::class,"temp_products_vendors");
    }
}
