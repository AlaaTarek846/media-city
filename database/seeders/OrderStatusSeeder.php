<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        OrderStatus::truncate();

        //normal order status

        $OrderStatuss = [
            [
                'name' => 'طلب جديد',
                'name_e' => 'New Order',
            ],
            [
                'name' => 'تجهيز الطلب',
                'name_e' => 'Preparing Order',
            ],
            [
                'name' => ' في الطريق',
                'name_e' => 'On The Way',
            ],
            [
                'name' => 'تم التسليم',
                'name_e' => 'Delivered',
            ],
            [
                'name' => 'إلغاء الطلب',
                'name_e' => 'Canceled',
            ],
            [
                'name'   => 'رفض',
                'name_e' => 'Rejected',
            ]
        ];



        foreach ($OrderStatuss as $key => $value) {
            $OrderStatus = OrderStatus::create([
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            $OrderStatus->setTranslations([
                'ar' => [
                    'title'       => $value['name'],
                    'description' => '',
                ],
                'en' => [
                    'title'       => $value['name_e'],
                    'description' => '',
                ],
            ]);

        }

    }
}
