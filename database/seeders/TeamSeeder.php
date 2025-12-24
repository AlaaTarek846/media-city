<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Team::truncate();

        $team = Team::create([
            'image'   => 'team-01.png',
            'instagram'    => 'https://www.instagram.com',
            'facebook'    => 'https://www.facebook.com',
            'x'    => 'https://x.com',
        ]);

        $team->setTranslations([
            'en' => [
                'title'       => 'James Dean',
                'description' => 'Cashier Supervisor',
            ],
            'ar' => [
                'title'       => 'جيمس دين',
                'description' => 'مشرف الصندوق',
            ],
        ]);

         $team = Team::create([
            'image'   => 'team-04.png',
            'instagram'    => 'https://www.instagram.com',
            'facebook'    => 'https://www.facebook.com',
            'x'    => 'https://x.com',
        ]);

        $team->setTranslations([
            'en' => [
                'title'       => 'Emma Rose',
                'description' => 'Sales Associate',
            ],
            'ar' => [
                'title'       => 'إيما روز',
                'description' => 'مساعد مبيعات',
            ],
        ]);

         $team = Team::create([
            'image'   => 'team-02.png',
            'instagram'    => 'https://www.instagram.com',
            'facebook'    => 'https://www.facebook.com',
            'x'    => 'https://x.com',
        ]);

        $team->setTranslations([
            'en' => [
                'title'       => 'John Paul',
                'description' => 'Inventory Specialist',
            ],
            'ar' => [
                'title'       => 'جون بول',
                'description' => 'أخصائي المخزون',
            ],
        ]);

        $team = Team::create([
            'image'   => 'team-03.png',
            'instagram'    => 'https://www.instagram.com',
            'facebook'    => 'https://www.facebook.com',
            'x'    => 'https://x.com',
        ]);

        $team->setTranslations([
            'en' => [
                'title'       => 'Anna Marie',
                'description' => 'Store Manager',
            ],
            'ar' => [
                'title'       => 'آنا ماري',
                'description' => 'مدير المتجر',
            ],
        ]);
    }
}
