<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUs::truncate();
        $contact = ContactUs::create([
            'email' => 'info@example.com',
            'mobile' => '+20 1095258832',
            'twitter' => 'https://twitter.com/',
            'instagram' => 'https://www.instagram.com/',
            'facebook' => 'https://www.facebook.com/',
            'linkedin' => 'https://linkedin.com/',
            'address_ar' =>"7 شارع الجلاء البحري – شبين الكوم – المنوفية <br/> مصوغات العسلي للمجوهرات",
            'address_en' => "7 Elgalaa Elbahary St. - Shebin Elkom <br/> - Menoufia Al-Asaly Jewelry",
            'map' => '<iframe
                    src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d2994.3803116994895!2d55.29773782339708!3d25.222534631321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m5!1s0x3e5f43496ad9c645%3A0xbde66e5084295162!2sDubai%20-%20United%20Arab%20Emirates!3m2!1d25.2048493!2d55.2707828!4m0!5e1!3m2!1sen!2sin!4v1652217109535!5m2!1sen!2sin"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>'
        ]);
    }
}
