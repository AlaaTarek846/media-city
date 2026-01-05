<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Slider::truncate();
        $Slider = Slider::create([
            'image'   => 'home-bg.png',
        ]);
        $Slider = Slider::create([
            'image'   => 'background.png',
        ]);
        $Slider = Slider::create([
            'image'   => 'home-bg2.png',
        ]);

        $Slider = Slider::create([
            'image'   => 'background1.png',
        ]);



    }
}
