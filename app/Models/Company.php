<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'name',"arName", 'email', 'address',"arAddress", 'phone', 'location', 'industry',"arIndustry",
        'payment_terms', 'commercial_registration_number', 'commercial_registration_image',
        'tax_id', 'tax_image', 'image', 'city_id', 'discount_type_id', 'created_by',"status"
    ];
    public function feedback()  {
        return $this->hasMany(CompanyFeedback::class);
    }
    public function company_responsible_info()  {
        return $this->hasOne(CompanyResponsibleInfo::class);
    }
    public function order(){
        return $this->hasMany(Order::class);
    }
    public function price_request()  {
        return $this->hasMany(PriceRequest::class);
    }
    public function user(){
        return $this->belongsTo(User::class,"created_by");
    }
    public function city()  {
        return $this->belongsTo(City::class);
    }
    public function discount_type()  {
        return $this->belongsTo(DiscountType::class);
    }
    public function payment_term(){
        return $this->belongsTo(PaymentTerm::class);
    }
}
