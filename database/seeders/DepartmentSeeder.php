<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Department::truncate();

        $department = Department::create([
            'image'   => 'rent.png',
        ]);

        $department->setTranslations([
            'ar' => [
                'title' => 'الإيجار',
            ],
            'en' => [
                'title'       => 'Renting',
            ],

        ]);

        $department = Department::create([
            'image'   => 'rent.png',
        ]);

        $department->setTranslations([
            'ar' => [
                'title' => 'الشراء',
            ],
            'en' => [
                'title'       => 'Buying',
            ],

        ]);


    }
}
