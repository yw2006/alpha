<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    /** @use HasFactory<\Database\Factories\AttributeFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
"name",
"arName",
"status"
    ];
    protected $hidden = [
        "deleted_at"
    ];
    public function values()  {
        return $this->hasMany(AttributeValue::class);
    }
}
