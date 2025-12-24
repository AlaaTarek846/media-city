<?php

namespace Database\Seeders;

use App\Models\DiscountCoupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DiscountCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        DiscountCoupon::truncate();

        $numberOfCoupons = 10;


        for ($i = 0; $i < $numberOfCoupons; $i++) {

            $code = Str::random(8);
            $type = rand(0, 1) ? 'fixed' : 'percentage';
            $value = rand(1, 100);
            $user_count = rand(0, 100);
            $start_date = Carbon::now()->subDays(rand(1, 20))->startOfDay();
            $expire_date = Carbon::now()->addDays(rand(1, 30))->endOfDay();
            $greater_than = rand(0, 100);
            $status = rand(0, 1);


           $coupon = DiscountCoupon::create([
                'code' => $code,
                'type' => $type,
                'value' => $value,
                'user_count' => $user_count,
                'start_date' => $start_date,
                'expire_date' => $expire_date,
                'greater_than' => $greater_than,
                'status' => $status,
            ]);

            $coupon->setTranslations([
                'ar' => [
                    'title' => 'كوبون'.$i,
                    'description' => 'وصف الكوبون '.$i,
                ],
                'en' => [
                    'title'       => "coupon".$i,
                    'description' => "Description of coupon ".$i,
                ],

            ]);
        }

    }
}
