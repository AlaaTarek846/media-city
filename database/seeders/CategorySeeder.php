<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Note: Images should be placed in public/upload/general/
     * All images should have similar dimensions to Cinema-camera.png
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Category::truncate();

        // DSLR Cameras Category
        $Category = Category::create([
            'image'   => 'Cinema-camera1.png', // TODO: Replace with DSLR camera icon
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'كاميرات DSLR',
            ],
            'en' => [
                'title'       => 'DSLR Cameras',
            ],

        ]);

         // Mirrorless Cameras Category
         $Category = Category::create([
            'image'   => 'Cinema-camera2.png', // TODO: Replace with Mirrorless camera icon
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'كاميرات Mirrorless',
            ],
            'en' => [
                'title'       => 'Mirrorless Cameras',
            ],

        ]);

        // Video Cameras Category
        $Category = Category::create([
            'image'   => 'Cinema-camera3.png', // TODO: Replace with Video camera icon
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'كاميرات الفيديو',
            ],
            'en' => [
                'title'       => 'Video Cameras',
            ],

        ]);

         // Lenses Category
         $Category = Category::create([
            'image'   => 'lenses.png', // Image already appropriate for lenses
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'العدسات',
            ],
            'en' => [
                'title'       => 'Lenses',
            ],

        ]);

        // Lighting Equipment Category
        $Category = Category::create([
            'image'   => 'illumination.png', // Image already appropriate for lighting
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الإضاءة',
            ],
            'en' => [
                'title' => 'Lighting Equipment',
            ],

        ]);

        // Tripods & Stands Category
        $Category = Category::create([
            'image'   => 'tripod1.png', // Image already appropriate for tripods
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الحاملات والستاندات',
            ],
            'en' => [
                'title' => 'Tripods & Stands',
            ],

        ]);

        // Tripod Category
        $Category = Category::create([
            'image'   => 'tripod.png', // Image already appropriate for tripod
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الحاملات',
            ],
            'en' => [
                'title' => 'Tripod',
            ],

        ]);

        // Microphones Category
        $Category = Category::create([
            'image'   => 'mic.png', // Image already appropriate for microphones
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'الميكروفونات',
            ],
            'en' => [
                'title' => 'Mic',
            ],

        ]);

        // Cinema Camera Category
        $Category = Category::create([
            'image'   => 'Cinema-camera.png', // Image already appropriate for cinema camera
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
