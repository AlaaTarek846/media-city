<?php

namespace Database\Seeders;

use Database\Seeders\Restaurant\RestKitchenSectionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(CreateAdminSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(JoinUsSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(ContactUsSeeder::class);
        $this->call(AboutUsSeeder::class);
        $this->call(VisionSeeder::class);
        $this->call(ProductAttributeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ShopByInstagramSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(DiscountCouponSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ShippingInformationSeeder::class);
        $this->call(ReturnPolicySeeder::class);

    }
}
