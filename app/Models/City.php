<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    //
    use SoftDeletes,HasFactory;
    // App\Models\City.php
protected $fillable = ['name', 'arName'];
protected $hidden = ['created_at','updated_at','deleted_at'];
}
