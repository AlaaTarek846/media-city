<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\HeaderOffer;
use Illuminate\Database\Seeder;

class HeaderOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeaderOffer::truncate();
        $HeaderOffer = HeaderOffer::create([
            "status"    => true,
        ]);
        $HeaderOffer->setTranslations([
            'ar' => [
                'title' => '',
                'description' => 'وفر حتى 50% على أفضل الكاميرات الاحترافية'
            ],
            'en' => [
                'title'       => '',
                'description' => 'Save up to 50% on the best professional cameras'
            ],

        ]);

        $HeaderOffer = HeaderOffer::create([
            "status"    => true,
        ]);

        $HeaderOffer->setTranslations([
            'ar' => [
                'title' => '',
                'description' => 'اكتشف مجموعة واسعة من معدات التصوير بأسعار مميزة'
            ],
            'en' => [
                'title'       => '',
                'description' => 'Discover a wide range of photography equipment at great prices'
            ],

        ]);

        $HeaderOffer = HeaderOffer::create([
            "status"    => true,
        ]);

        $HeaderOffer->setTranslations([
            'ar' => [
                'title' => '',
                'description' => 'أجر أفضل معدات التصوير بأسعار مناسبة لجميع المشاريع'
            ],
            'en' => [
                'title'       => '',
                'description' => 'Rent the best photography equipment at affordable prices for all projects'
            ],

        ]);

        $HeaderOffer = HeaderOffer::create([
            "status"    => true,
        ]);

        $HeaderOffer->setTranslations([
            'ar' => [
                'title' => '',
                'description' => 'تصفح المنتجات الأكثر طلباً من عملائنا'
            ],
            'en' => [
                'title'       => '',
                'description' => 'Browse the most requested products from our customers'
            ],

        ]);

    }
}
