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
                'name' => 'قيد التنفيذ',
                'name_e' => 'In progress',
            ],
            [
                'name' => 'تم التسليم',
                'name_e' => 'Delivered',
            ],
            [
                'name' => 'ملغي',
                'name_e' => 'Canceled',
            ],
        ];

        // hala car go status

        // $OrderStatuss = [
        //     [
        //         'name' => 'تم استلام البيكب',
        //         'name_e' => 'Pickup received',
        //     ],
        //     [
        //         'name' => 'تم تسليم البيكب في المخزن',
        //         'name_e' => 'Pickup delivered to warehouse',
        //     ],
        //      [
        //         'name' => 'توصيل',
        //         'name_e' => 'Delivery',
        //     ],
        //     [
        //         'name' => 'تم التسليم',
        //         'name_e' => 'Delivered',
        //     ],
        //     [
        //         'name' => 'تاجيل',
        //         'name_e' => 'Postponed',
        //     ],
        //     [
        //         'name' => 'رفض',
        //         'name_e' => 'Rejected',
        //     ],
        //     [
        //         'name' => 'رفض ورفض يدفع شحن',
        //         'name_e' => 'Rejected and refused to pay shipping',
        //     ],
        //      [
        //         'name' => 'استرجاع جزئي',
        //         'name_e' => 'Partial return',
        //     ],
        //     [
        //         'name' => 'تحت الفرز',
        //         'name_e' => 'Under review',
        //     ],
        //     [
        //         'name' => 'رفض استلام الشحنة من المندوب',
        //         'name_e' => 'Refused to receive the shipment from the representative',
        //     ],
        //     [
        //         'name' => 'استبدال',
        //         'name_e' => 'Exchange',
        //     ],
        //     [
        //         'name' => 'مشكلة',
        //         'name_e' => 'Problem',
        //     ],
        //     [
        //         'name' => 'عنوان خطأ',
        //         'name_e' => 'Wrong address',
        //     ],
        //     [
        //         'name' => 'عنوان غير واضح',
        //         'name_e' => 'Unclear address',
        //     ],
        //     [
        //         'name' => 'عدم رد',
        //         'name_e' => 'No response',
        //     ],
        //     [
        //         'name' => 'مغلق',
        //         'name_e' => 'Closed',
        //     ],
        //     [
        //         'name' => 'الرقم غير مجمع',
        //         'name_e' => 'Number not collected',
        //     ],
        //     [
        //         'name' => 'الشبكه مشغوله',
        //         'name_e' => 'Network busy',
        //     ],
        //     [
        //         'name' => 'بيانات ناقصه',
        //         'name_e' => 'Incomplete data',
        //     ],
        //     [
        //         'name' => 'رفض الاستلام بعد الذهاب',
        //         'name_e' => 'Refused to receive after going',
        //     ],
        //     [
        //         'name' => 'رفض الاستلام تليفونياٌٌ',
        //         'name_e' => 'Refused to receive by phone',
        //     ],
        //     [
        //         'name' => 'تهرب بعد الذهاب',
        //         'name_e' => 'Avoided after going',
        //     ],
        //     [
        //         'name' => 'تأجيل بدون موعد',
        //         'name_e' => 'Postponed without a date',
        //     ],
        //     [
        //         'name' => 'مسافر',
        //         'name_e' => 'Traveler',
        //     ],
        //     [
        //         'name' => 'مكرر',
        //         'name_e' => 'Duplicate',
        //     ],
        // ];


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
