<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorResponsibleInfo extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'vendor_id',
           'name',
           'arName',
           'mobile',
           'whatsapp_mobile',
           'title',
           'arTitle'
    ];
    protected $hidden = [
        "deleted_at"
    ];
}
