<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Category::truncate();

        $Category = Category::create([
            'image'   => 'Cinema-camera1.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'كاميرات DSLR',
            ],
            'en' => [
                'title'       => 'DSLR Cameras',
            ],

        ]);

         $Category = Category::create([
            'image'   => 'Cinema-camera2.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'كاميرات Mirrorless',
            ],
            'en' => [
                'title'       => 'Mirrorless Cameras',
            ],

        ]);

        $Category = Category::create([
            'image'   => 'Cinema-camera3.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'كاميرات الفيديو',
            ],
            'en' => [
                'title'       => 'Video Cameras',
            ],

        ]);

         $Category = Category::create([
            'image'   => 'lenses.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'العدسات',
            ],
            'en' => [
                'title'       => 'Lenses',
            ],

        ]);

        $Category = Category::create([
            'image'   => 'illumination.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الإضاءة',
            ],
            'en' => [
                'title' => 'Lighting Equipment',
            ],

        ]);

        $Category = Category::create([
            'image'   => 'tripod1.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الحاملات والستاندات',
            ],
            'en' => [
                'title' => 'Tripods & Stands',
            ],

        ]);

        $Category = Category::create([
            'image'   => 'tripod.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الحاملات',
            ],
            'en' => [
                'title' => 'Tripod',
            ],

        ]);

        $Category = Category::create([
            'image'   => 'mic.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الميكروفونات',
            ],
            'en' => [
                'title' => 'Mic',
            ],

        ]);

        $Category = Category::create([
            'image'   => 'Cinema-camera.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'كاميرات السينما',
            ],
            'en' => [
                'title' => 'Cinema Camera',
            ],

        ]);

    }
}
