<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceRequest extends Model
{
    use SoftDeletes,HasFactory;
    public function company()
{
    return $this->belongsTo(Company::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
