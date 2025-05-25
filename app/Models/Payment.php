<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use SoftDeletes,HasFactory;
    public function getPaymentStatusTextAttribute(): string
    {
        $lang = request()->query('lang', 'en'); // fallback to 'en'
    
        $map = [
            '0' => ['en' => 'Paid',      'ar' => 'مدفوع'],
            '1' => ['en' => 'Pending',   'ar' => 'قيد الانتظار'],
            '2' => ['en' => 'Partial',   'ar' => 'جزئي'],
            '3' => ['en' => 'Cancelled', 'ar' => 'ملغي'],
        ];
    
        return $map[$this->payment_status][$lang] ?? 'Unknown';
    }
}
