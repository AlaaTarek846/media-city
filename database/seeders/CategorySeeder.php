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
            'image'   => '01.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'أزياء الرجال',
            ],
            'en' => [
                'title'       => 'Men Fashion',
            ],

        ]);

         $Category = Category::create([
            'image'   => '02.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'أزياء النساء',
            ],
            'en' => [
                'title'       => 'Women',
            ],

        ]);

        $Category = Category::create([
            'image'   => '03.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'أزياء الأطفال',
            ],
            'en' => [
                'title'       => 'Kids Fashion',
            ],

        ]);

         $Category = Category::create([
            'image'   => '05.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'قمصان',
            ],
            'en' => [
                'title'       => 'Shirts',
            ],

        ]);

        $Category = Category::create([
            'image'   => '07.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'فساتين',
            ],
            'en' => [
                'title' => 'Dresses',
            ],

        ]);

        $Category = Category::create([
            'image'   => '09.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'أحذية',
            ],
            'en' => [
                'title' => 'Shoes',
            ],

        ]);

        $Category = Category::create([
            'image'   => '10.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'حقائب',
            ],
            'en' => [
                'title' => 'Bags',
            ],

        ]);

        $Category = Category::create([
            'image'   => '11.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'ساعات',
            ],
            'en' => [
                'title' => 'Watches',
            ],

        ]);

        $Category = Category::create([
            'image'   => '12.png',
        ]);

        $Category->setTranslations([
            'ar' => [
                'title' => 'ملابس علوية',
            ],
            'en' => [
                'title' => 'Top wear',
            ],

        ]);

    }
}
