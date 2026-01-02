<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Area::truncate();

        $areas = [
            ['name' => 'القاهرة', 'name_e' => 'Cairo', 'shipping_price' => 30],
            ['name' => 'الجيزة', 'name_e' => 'Giza', 'shipping_price' => 30],
            ['name' => 'الإسكندرية', 'name_e' => 'Alexandria', 'shipping_price' => 35],
            ['name' => 'الدقهلية', 'name_e' => 'Dakahlia', 'shipping_price' => 40],
            ['name' => 'البحيرة', 'name_e' => 'Beheira', 'shipping_price' => 40],
            ['name' => 'الفيوم', 'name_e' => 'Faiyum', 'shipping_price' => 45],
            ['name' => 'الغربية', 'name_e' => 'Gharbia', 'shipping_price' => 40],
            ['name' => 'الإسماعيلية', 'name_e' => 'Ismailia', 'shipping_price' => 45],
            ['name' => 'المنوفية', 'name_e' => 'Monufia', 'shipping_price' => 40],
            ['name' => 'المنيا', 'name_e' => 'Minya', 'shipping_price' => 50],
            ['name' => 'القليوبية', 'name_e' => 'Qalyubia', 'shipping_price' => 35],
            ['name' => 'الشرقية', 'name_e' => 'Sharqia', 'shipping_price' => 40],
            ['name' => 'سوهاج', 'name_e' => 'Sohag', 'shipping_price' => 55],
            ['name' => 'أسيوط', 'name_e' => 'Asyut', 'shipping_price' => 55],
            ['name' => 'بني سويف', 'name_e' => 'Beni Suef', 'shipping_price' => 50],
            ['name' => 'بورسعيد', 'name_e' => 'Port Said', 'shipping_price' => 45],
            ['name' => 'دمياط', 'name_e' => 'Damietta', 'shipping_price' => 40],
            ['name' => 'السويس', 'name_e' => 'Suez', 'shipping_price' => 45],
            ['name' => 'شمال سيناء', 'name_e' => 'North Sinai', 'shipping_price' => 60],
            ['name' => 'جنوب سيناء', 'name_e' => 'South Sinai', 'shipping_price' => 60],
            ['name' => 'كفر الشيخ', 'name_e' => 'Kafr El Sheikh', 'shipping_price' => 40],
            ['name' => 'مطروح', 'name_e' => 'Matruh', 'shipping_price' => 60],
            ['name' => 'الأقصر', 'name_e' => 'Luxor', 'shipping_price' => 60],
            ['name' => 'قنا', 'name_e' => 'Qena', 'shipping_price' => 60],
            ['name' => 'أسوان', 'name_e' => 'Aswan', 'shipping_price' => 65],
            ['name' => 'البحر الأحمر', 'name_e' => 'Red Sea', 'shipping_price' => 60],
            ['name' => 'الوادي الجديد', 'name_e' => 'New Valley', 'shipping_price' => 70],
        ];

        foreach ($areas as $key => $value) {
            $area = Area::create([
                'status'        => 1,
                'shipping_price' => $value['shipping_price'] ?? 50,
            ]);

            $area->setTranslations([
                'ar' => [
                    'title'       => $value['name'],
                    'description' => '',
                ],
                'en' => [
                    'title'       => $value['name_e'],
                    'description' => '',
                ],
            ]);
        }

    }
}
