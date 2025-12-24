<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ProductAttribute::truncate();

        $variant = ProductAttribute::create([
            'id'   => 1,
        ]);

        $variant->setTranslations([
            'ar' => [
                'title'       => 'المقاس',
            ],
            'en' => [
                'title'       => 'Size',
            ],
        ]);

         $variant = ProductAttribute::create([
            'id'   => 2,
        ]);

        $variant->setTranslations([
            'ar' => [
                'title'       => 'اللون',
            ],
            'en' => [
                'title'       => 'Color',
            ],
        ]);

    }
}
