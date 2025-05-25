<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyResponsibleInfo extends Model
{
    //
    use SoftDeletes,HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        "arName",
        'mobile',
        'whatsapp_mobile',
        'title',
        "arTitle"
    ];
}
