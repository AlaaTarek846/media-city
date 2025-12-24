<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Country::truncate();

        // add egypt
        $country = Country::create([
            'image' => 'egypt.jpg',
            'phone_code'   => '+20',
            'alpha_code' =>'EG',
            'number_of_phone_digits' =>10,
            'status' => 1,
        ]);
        $country->setTranslations([
            'ar' => [
            'title'       => 'مصر',
            'description' => 'مصر',
            ],
            'en' => [
            'title'       => 'Egypt',
            'description' => 'Egypt',
            ],
        ]);

    }
}
