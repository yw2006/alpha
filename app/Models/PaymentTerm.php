<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTerm extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'name',
        'arName',
        'kind',
        'arKind',
        'period',
        'arPeriod',
        'status'
    ];
    protected $hidden = [
        "deleted_at"
    ];
}
