<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempProduct extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = ['title', 'stock', 'description', 'price'];
}
