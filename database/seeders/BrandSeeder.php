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
                'title' => 'أمازون',
            ],
            'en' => [
                'title'       => 'Amazon',
            ],

        ]);

         $Brand = Brand::create([
            'image'   => 'br-08.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'بومة',
            ],
            'en' => [
                'title'       => 'Puma',
            ],

        ]);

         $Brand = Brand::create([
            'image'   => 'br-09.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'أديداس',
            ],
            'en' => [
                'title'       => 'Adidas',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-10.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'نيو بالانس',
            ],
            'en' => [
                'title'       => 'New Balance',
            ],

        ]);

        $Brand = Brand::create([
            'image'   => 'br-04.webp',
        ]);

        $Brand->setTranslations([
            'ar' => [
                'title' => 'سامسونج',
            ],
            'en' => [
                'title'       => 'Samsung',
            ],

        ]);

    }
}
