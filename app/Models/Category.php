<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'name',"arName","sub_category"
    ];
    public function sub_categories(){
      return $this->hasMany(Category::class,"sub_category");  
    }

    protected $hidden = ['pivot'];
    public function products(){
      return $this->belongsToMany(Product::class,"products_categories");
  }

}
