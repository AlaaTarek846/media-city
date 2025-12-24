<?php

namespace Database\Seeders;

use App\Models\ShopByInstagram;
use Illuminate\Database\Seeder;

class ShopByInstagramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        ShopByInstagram::truncate();

        ShopByInstagram::create([
            'image'   => 'insta-01.png',
            'link'    => 'https://www.instagram.com',
        ]);

        ShopByInstagram::create([
            'image'   => 'insta-02.png',
            'link'    => 'https://www.instagram.com',
        ]);

        ShopByInstagram::create([
            'image'   => 'insta-03.png',
            'link'    => 'https://www.instagram.com',
        ]);

        ShopByInstagram::create([
            'image'   => 'insta-04.png',
            'link'    => 'https://www.instagram.com',
        ]);

        ShopByInstagram::create([
            'image'   => 'insta-05.png',
            'link'    => 'https://www.instagram.com',
        ]);

        ShopByInstagram::create([
            'image'   => 'insta-06.png',
            'link'    => 'https://www.instagram.com',
        ]);
    }
}
