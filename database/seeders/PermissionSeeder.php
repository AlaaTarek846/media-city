<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Notify;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            ['name' => 'banner read',  'category' => 'Banners'],
            ['name' => 'banner create',  'category' => 'Banners'],
            ['name' => 'banner edit',  'category' => 'Banners'],
            ['name' => 'banner delete',  'category' => 'Banners'],

            ['name' => 'admin read',  'category' => 'Admins'],
            ['name' => 'admin create',  'category' => 'Admins'],
            ['name' => 'admin edit',  'category' => 'Admins'],
            ['name' => 'admin delete',  'category' => 'Admins'],
            ['name' => 'admin send notification'  ,  'category' => 'Admins'],


            ['name' => 'role read',  'category' => 'Roles'],
            ['name' => 'role create',  'category' => 'Roles'],
            ['name' => 'role edit',  'category' => 'Roles'],
            ['name' => 'role delete',  'category' => 'Roles'],

            ['name' => 'language read',  'category' => 'Languages'],
            ['name' => 'language create',  'category' => 'Languages'],
            ['name' => 'language edit',  'category' => 'Languages'],
            ['name' => 'language delete',  'category' => 'Languages'],

            ['name' => 'category read'  ,  'category' => 'Categories'],
            ['name' => 'category create',  'category' => 'Categories'],
            ['name' => 'category edit'  ,  'category' => 'Categories'],
            ['name' => 'category delete',  'category' => 'Categories'],

            ['name' => 'country read'  ,  'category' => 'Countries'],
            ['name' => 'country create',  'category' => 'Countries'],
            ['name' => 'country edit'  ,  'category' => 'Countries'],
            ['name' => 'country delete',  'category' => 'Countries'],

            ['name' => 'frequently asked question read'  ,  'category' => 'Frequently Asked Question'],
            ['name' => 'frequently asked question create',  'category' => 'Frequently Asked Question'],
            ['name' => 'frequently asked question edit'  ,  'category' => 'Frequently Asked Question'],
            ['name' => 'frequently asked question delete',  'category' => 'Frequently Asked Question '],

            ['name' => 'database backup read',  'category' => 'Database Backup'],
            ['name' => 'database backup create',  'category' => 'Database Backup'],

            ['name' => 'join us read',  'category' => 'Join Us'],
            ['name' => 'join us edit',  'category' => 'Join Us'],

            ['name' => 'area read'  ,  'category' => 'Areas'],
            ['name' => 'area create',  'category' => 'Areas'],
            ['name' => 'area edit'  ,  'category' => 'Areas'],
            ['name' => 'area delete',  'category' => 'Areas'],

            ['name' => 'testimonial read'  ,  'category' => 'Testimonials'],
            ['name' => 'testimonial create',  'category' => 'Testimonials'],
            ['name' => 'testimonial edit'  ,  'category' => 'Testimonials'],
            ['name' => 'testimonial delete',  'category' => 'Testimonials'],

            ['name' => 'brand read'  ,  'category' => 'Brand'],
            ['name' => 'brand create',  'category' => 'Brand'],
            ['name' => 'brand edit'  ,  'category' => 'Brand'],
            ['name' => 'brand delete',  'category' => 'Brand'],

            ['name' => 'news read'  ,  'category' => 'news'],
            ['name' => 'news create',  'category' => 'news'],
            ['name' => 'news edit'  ,  'category' => 'news'],
            ['name' => 'news delete',  'category' => 'news'],

            ['name' => 'contact us read',  'category' => 'Contact Us'],
            ['name' => 'contact us edit',  'category' => 'Contact Us'],
            ['name' => 'contact message read',  'category' => 'Contact Us'],

            ['name' => 'newsletter read',  'category' => 'Newsletter'],

            ['name' => 'about us read',  'category' => 'About Us'],
            ['name' => 'about us edit',  'category' => 'About Us'],
            ['name' => 'vision read',  'category' => 'About Us'],
            ['name' => 'vision edit',  'category' => 'About Us'],
            ['name' => 'team read'  ,  'category' => 'About Us'],
            ['name' => 'team create',  'category' => 'About Us'],
            ['name' => 'team edit'  ,  'category' => 'About Us'],
            ['name' => 'team delete',  'category' => 'About Us'],

            ['name' => 'user read'  ,  'category' => 'User'],
            ['name' => 'user edit'  ,  'category' => 'User'],
            ['name' => 'user send notification'  ,  'category' => 'User'],

            ['name' => 'product attribute read'  ,  'category' => 'Product Attributes'],
            ['name' => 'product attribute create',  'category' => 'Product Attributes'],
            ['name' => 'product attribute edit'  ,  'category' => 'Product Attributes'],
            ['name' => 'product attribute delete',  'category' => 'Product Attributes'],

            ['name' => 'product read'  ,  'category' => 'Products'],
            ['name' => 'product create',  'category' => 'Products'],
            ['name' => 'product edit'  ,  'category' => 'Products'],
            ['name' => 'product delete',  'category' => 'Products'],

            ['name' => 'shop by instagram read'  ,  'category' => 'Shop By Instagram'],
            ['name' => 'shop by instagram create',  'category' => 'Shop By Instagram'],
            ['name' => 'shop by instagram edit'  ,  'category' => 'Shop By Instagram'],
            ['name' => 'shop by instagram delete',  'category' => 'Shop By Instagram'],

            ['name' => 'discount coupon read'  ,  'category' => 'Discount Coupons'],
            ['name' => 'discount coupon create',  'category' => 'Discount Coupons'],
            ['name' => 'discount coupon edit'  ,  'category' => 'Discount Coupons'],
            ['name' => 'discount coupon delete',  'category' => 'Discount Coupons'],

            ['name' => 'order read'  ,  'category' => 'Orders'],
            ['name' => 'order edit'  ,  'category' => 'Orders'],


            ['name' => 'setting read'  ,  'category' => 'Setting'],
            ['name' => 'setting edit'  ,  'category' => 'Setting'],
            ['name' => 'return policy read'  ,  'category' => 'Setting'],
            ['name' => 'return policy edit'  ,  'category' => 'Setting'],
            ['name' => 'shipping information read'  ,  'category' => 'Setting'],
            ['name' => 'shipping information edit'  ,  'category' => 'Setting'],


        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']],[
                'name' => $permission['name'],
                'category' => $permission['category'],
            ]);
        }
    }
}
