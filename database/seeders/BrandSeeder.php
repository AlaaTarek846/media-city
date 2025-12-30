<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Brand::truncate();

        $Brand = Brand::create([
            'image'   => 'br-01.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'كانون',
            ],
            'en' => [
                'title'       => 'Canon',
            ],

        ]);

         $Brand = Brand::create([
            'image'   => 'br-08.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'نيكون',
            ],
            'en' => [
                'title'       => 'Nikon',
            ],

        ]);

         $Brand = Brand::create([
            'image'   => 'br-09.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'سوني',
            ],
            'en' => [
                'title'       => 'Sony',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-10.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'باناسونيك',
            ],
            'en' => [
                'title'       => 'Panasonic',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-04.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'فوجي فيلم',
            ],
            'en' => [
                'title'       => 'Fujifilm',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-05.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'مانفروتو',
            ],
            'en' => [
                'title'       => 'Manfrotto',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-06.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'رود',
            ],
            'en' => [
                'title'       => 'Rode',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-07.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'جودوكس',
            ],
            'en' => [
                'title'       => 'Godox',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-11.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'سيجما',
            ],
            'en' => [
                'title'       => 'Sigma',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-12.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'تامرون',
            ],
            'en' => [
                'title'       => 'Tamron',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-13.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'دي جي آي',
            ],
            'en' => [
                'title'       => 'DJI',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-14.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'جوبرو',
            ],
            'en' => [
                'title'       => 'GoPro',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-15.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'لويبرو',
            ],
            'en' => [
                'title'       => 'Lowepro',
            ],

        ]);

    }
}
