<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes,HasFactory;
public function getOrderStatusTextAttribute(): string
{
    $lang = request()->query('lang', 'en');

    $map = [
        '0' => ['en' => 'Pending',         'ar' => 'قيد الانتظار'],
        '1' => ['en' => 'Processing',      'ar' => 'قيد المعالجة'],
        '2' => ['en' => 'Shipped',         'ar' => 'تم الشحن'],
        '3' => ['en' => 'Delivered',       'ar' => 'تم التوصيل'],
        '4' => ['en' => 'Cancelled',       'ar' => 'ملغي'],
        '5' => ['en' => 'Returned',        'ar' => 'تم الإرجاع'],
        '6' => ['en' => 'Partial Return',  'ar' => 'إرجاع جزئي'],
    ];

    return $map[$this->order_status][$lang] ?? 'Unknown';
}
public function payments()
{
    return $this->hasMany(Payment::class);
}

public function getTotalPaidAttribute()
{
    return $this->payments()->sum('amount_paid');
}

public function getTotalRemainingAttribute()
{
    return $this->payments()->sum('remain_amount');
}


}
