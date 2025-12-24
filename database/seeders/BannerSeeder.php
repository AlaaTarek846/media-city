<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Banner::truncate();

        $Brand = Banner::create([
            'image'   => 'slide-5.png',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'الأناقة المعاد تعريفها',
                'description' => 'تسوق أحدث الصيحات الآن'
            ],
            'en' => [
                'title'       => 'Elegance Redefined',
                'description' => 'Shop the latest trends now'
            ],

        ]);

        $Brand = Banner::create([
            'image'   => 'slide-2.png',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'خزانة الأناقة',
                'description' => 'تأنق، اشعر بالروعة'
            ],
            'en' => [
                'title'       => 'The Chic Closet',
                'description' => 'Dress up, feel amazing'
            ],

        ]);

        $Brand = Banner::create([
            'image'   => 'slide-3.png',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'أسلوب الروح البوهيمية',
                'description' => 'اكتشف قطع البيان اليوم'
            ],
            'en' => [
                'title'       => 'Gypsy Soul Styles',
                'description' => 'Discover statement pieces today'
            ],

        ]);

         $Brand = Banner::create([
            'image'   => 'slide-4.png',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'يوميات أسلوب الشارع',
                'description' => 'ارتدي مثل الجمال الكلاسيكي'
            ],
            'en' => [
                'title'       => 'Street Style Diaries',
                'description' => 'Dress like a classic beauty'
            ],

        ]);

    }
}
