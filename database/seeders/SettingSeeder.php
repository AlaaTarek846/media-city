<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
        $contact = Setting::create([
            'shipping_price' => 50,
        ]);

        $contact->setTranslations([

            'en' => [
                'title'       => 'EGP',
                'description' => '',
            ],
            'ar' => [
                'title'       => 'ج.م',
                'description' => '',
            ],

        ]);
    }
}
