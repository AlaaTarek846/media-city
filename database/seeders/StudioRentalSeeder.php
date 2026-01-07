<?php

namespace Database\Seeders;

use App\Models\StudioRental;
use App\Models\Image;
use Illuminate\Database\Seeder;

class StudioRentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudioRental::truncate();
        Image::truncate();
        $StudioRental = StudioRental::create([
            "status"    => true,
        ]);
        $StudioRental->setTranslations([
            'ar' => [
                'title' => 'استوديو للإيجار',
                'description' => 'استوديو مجهز بالكامل لتصوير الصور والفيديو. إعداد نظيف، خيارات إضاءة احترافية، وحجز مرن.'
            ],
            'en' => [
                'title'       => 'Studio For Rent',
                'description' => 'Fully-equipped studio for photo & video shoots. Clean setup, pro lighting options, and flexible booking.'
            ],

        ]);

        // Add images
        $images = ['151.jpeg', '152.jpeg', '153.jpg'];
        foreach ($images as $image) {
            $StudioRental->images()->create([
                'image' => 'studio_rentals/' . $image
            ]);
        }

    }
}
