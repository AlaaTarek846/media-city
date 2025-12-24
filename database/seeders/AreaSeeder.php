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
            [

            'name' => 'دبي',
            'name_e' => 'Dubai',
            ],
            [

            'name' => 'أبو ظبي',
            'name_e' => 'Abu Dhabi',
            ],
            [

            'name' => 'الشارقة',
            'name_e' => 'Sharjah',
            ],
            [
            'name' => 'عجمان',
            'name_e' => 'Ajman',
            ],
            [

            'name' => 'أم القيوين',
            'name_e' => 'Umm Al Quwain',
            ],
            [

            'name' => 'رأس الخيمة',
            'name_e' => 'Ras Al Khaimah',
            ],
            [

            'name' => 'الفجيرة',
            'name_e' => 'Fujairah',
            ],
        ];

        foreach ($areas as $key => $value) {
            $area = Area::create([
                'status'   => 1,
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
