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
            'phone' => '+91-8623XXXXXX',
            'email' => 'example@gmail.com',
            'location' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52914395.551108696!2d-161.66682312048917!3d35.95581471346889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sin!4v1741246206129!5m2!1sen!2sin'
        ]);

        $contact->setTranslations([

            'en' => [
                'title'       => '84-A London Street, United Kingdom',
                'description' => 'Saturday - Thursday: 10:30 AM - 9:00 PM Syria Time',
            ],
            'ar' => [
                'title'       => '84-A شارع لندن، المملكة المتحدة',
                'description' => 'السبت - الخميس: 10:30 صباحًا - 9:00 مساءً بتوقيت سوريا',
            ],

        ]);
    }
}
