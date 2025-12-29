<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\CompanyProfile;
use App\Models\PersonProfile;
use App\Models\StudioProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UserProfileSeeder
 *
 * Creates sample users for each type (Person, Company, Studio)
 * with their corresponding profile records
 */
class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create Person User
        $personUser = User::create([
            'name' => 'أحمد محمد',
            'email' => 'person@example.com',
            'mobile' => '01234567890',
            'whatsapp' => '01234567890',
            'password' => Hash::make('123123123'),
            'user_type' => 'person',
            'how_did_you_hear_about_us' => 'facebook',
            'status' => true,
        ]);

        PersonProfile::create([
            'user_id' => $personUser->id,
            'social_media_link' => 'https://facebook.com/person',
            'id_card_front' => 'person_profiles/id_cards/front.jpg',
            'id_card_back' => 'person_profiles/id_cards/back.jpg',
        ]);

        // Create Company User
        $companyUser = User::create([
            'name' => 'شركة الإنتاج المحدودة',
            'email' => 'company@example.com',
            'mobile' => '01234567891',
            'whatsapp' => '01234567891',
            'password' => Hash::make('123123123'),
            'user_type' => 'company',
            'how_did_you_hear_about_us' => 'google',
            'status' => true,
        ]);

        CompanyProfile::create([
            'user_id' => $companyUser->id,
            'commercial_register_image' => 'company_profiles/documents/commercial_register.jpg',
            'tax_card_image' => 'company_profiles/documents/tax_card.jpg',
            'social_media_link' => 'https://facebook.com/company',
        ]);

        // Create Studio User
        $studioUser = User::create([
            'name' => 'استوديو الإبداع',
            'email' => 'studio@example.com',
            'mobile' => '01234567892',
            'whatsapp' => '01234567892',
            'password' => Hash::make('123123123'),
            'user_type' => 'studio',
            'how_did_you_hear_about_us' => 'instagram',
            'status' => true,
        ]);

        StudioProfile::create([
            'user_id' => $studioUser->id,
            'id_card_front' => 'studio_profiles/id_cards/front.jpg',
            'id_card_back' => 'studio_profiles/id_cards/back.jpg',
        ]);

        $this->command->info('Users and profiles created successfully!');
    }
}
