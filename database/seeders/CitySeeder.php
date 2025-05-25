<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //public function run(): void
    {
        $cities = [
            
                ['name' => 'Cairo', 'arName' => 'القاهرة'],
                ['name' => 'Alexandria', 'arName' => 'الإسكندرية'],
                ['name' => 'Giza', 'arName' => 'الجيزة'],
                ['name' => 'Dakahlia', 'arName' => 'الدقهلية'],
                ['name' => 'Red Sea', 'arName' => 'البحر الأحمر'],
                ['name' => 'Beheira', 'arName' => 'البحيرة'],
                ['name' => 'Fayoum', 'arName' => 'الفيوم'],
                ['name' => 'Gharbia', 'arName' => 'الغربية'],
                ['name' => 'Ismailia', 'arName' => 'الإسماعيلية'],
                ['name' => 'Monufia', 'arName' => 'المنوفية'],
                ['name' => 'Minya', 'arName' => 'المنيا'],
                ['name' => 'Qalyubia', 'arName' => 'القليوبية'],
                ['name' => 'New Valley', 'arName' => 'الوادي الجديد'],
                ['name' => 'Suez', 'arName' => 'السويس'],
                ['name' => 'Aswan', 'arName' => 'أسوان'],
                ['name' => 'Asyut', 'arName' => 'أسيوط'],
                ['name' => 'Beni Suef', 'arName' => 'بني سويف'],
                ['name' => 'Port Said', 'arName' => 'بورسعيد'],
                ['name' => 'Damietta', 'arName' => 'دمياط'],
                ['name' => 'South Sinai', 'arName' => 'جنوب سيناء'],
                ['name' => 'Kafr El Sheikh', 'arName' => 'كفر الشيخ'],
                ['name' => 'Matrouh', 'arName' => 'مطروح'],
                ['name' => 'Luxor', 'arName' => 'الأقصر'],
                ['name' => 'Qena', 'arName' => 'قنا'],
                ['name' => 'North Sinai', 'arName' => 'شمال سيناء'],
                ['name' => 'Sohag', 'arName' => 'سوهاج'],
                ['name' => 'Sharqia', 'arName' => 'الشرقية'],
                        
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
    }
}
