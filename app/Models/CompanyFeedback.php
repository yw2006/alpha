<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyFeedback extends Model
{
    //
    use SoftDeletes, HasFactory;
    protected $fillable = [
        "company_id",
        "note",
        "created_by"
    ];
    protected $hidden=[
        "deleted_at"
    ];
}
