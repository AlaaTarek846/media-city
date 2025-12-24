<?php

namespace Database\Seeders;

use App\Models\JoinUs;
use Illuminate\Database\Seeder;

class JoinUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JoinUs::truncate();
        JoinUs::create([
            'facebook'=> '#',
            'twitter'=> '#',
            'instagram'=> '#',
            'linkedin'=> '#',
            'youtube'=> '#',
            // 'phone'=> '166633',
        ]);

    }
}
