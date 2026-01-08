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
            'image'   => 'bannerHome.png',
            "type"    => 'home',
        ]);
        $Brand->setTranslations([
            'ar' => [
                'title' => 'عروض خاصة على كاميرات التصوير',
                'description' => 'وفر حتى 50% على أفضل الكاميرات الاحترافية'
            ],
            'en' => [
                'title'       => 'Special Offers on Photography Cameras',
                'description' => 'Save up to 50% on the best professional cameras'
            ],

        ]);

        $Brand = Banner::create([
            'image'   => 'bannerShop.png',
            "type"    => 'shop',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'تسوق من متجرنا الإلكتروني',
                'description' => 'اكتشف مجموعة واسعة من معدات التصوير بأسعار مميزة'
            ],
            'en' => [
                'title'       => 'Shop from Our Online Store',
                'description' => 'Discover a wide range of photography equipment at great prices'
            ],

        ]);

        $Brand = Banner::create([
            'image'   => 'bannerRenting.png',
            "type"    => 'shop',

        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'خدمة تأجير المعدات الاحترافية',
                'description' => 'أجر أفضل معدات التصوير بأسعار مناسبة لجميع المشاريع'
            ],
            'en' => [
                'title'       => 'Professional Equipment Rental Service',
                'description' => 'Rent the best photography equipment at affordable prices for all projects'
            ],

        ]);

         $Brand = Banner::create([
            'image'   => 'bannerBestSellers.png',
             "type"    => 'shop',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'الأكثر مبيعاً هذا الشهر',
                'description' => 'تصفح المنتجات الأكثر طلباً من عملائنا'
            ],
            'en' => [
                'title'       => 'Best Sellers This Month',
                'description' => 'Browse the most requested products from our customers'
            ],

        ]);

    }
}
