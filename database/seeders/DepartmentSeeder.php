<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use App\Models\DepartmentCategory;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Note: Images should be placed in public/upload/general/
     * All images should have similar dimensions to Cinema-camera.png
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Department::truncate();
        DepartmentCategory::truncate();

        // Renting Department - Key icon represents renting/leasing
        $department1 = Department::create([
            'image'   => 'rent.png', // Key icon - appropriate for renting/leasing
        ]);

        $department1->setTranslations([
            'ar' => [
                'title' => 'الإيجار',
            ],
            'en' => [
                'title'       => 'Renting',
            ],

        ]);

        // Buying Department - Shopping cart icon represents buying/purchasing
        $department2 = Department::create([
            'image'   => 'buy-button.png', // Shopping cart icon - appropriate for buying/purchasing
        ]);

        $department2->setTranslations([
            'ar' => [
                'title' => 'الشراء',
            ],
            'en' => [
                'title'       => 'Buying',
            ],

        ]);

        // ربط جميع الـ Categories بالـ Departments
        $categories = Category::all();
        
        foreach ($categories as $category) {
            // ربط Category بالـ Department الأول (الإيجار)
            DepartmentCategory::create([
                'department_id' => $department1->id,
                'category_id' => $category->id,
            ]);

            // ربط Category بالـ Department الثاني (الشراء)
            DepartmentCategory::create([
                'department_id' => $department2->id,
                'category_id' => $category->id,
            ]);
        }
    }
}
