<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\AboutUsFeature;
use App\Models\AboutUsStatistic;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * إنشاء بيانات افتراضية لصفحة About Us
     */
    public function run(): void
    {
        // إنشاء AboutUs الرئيسي
        $aboutUs = AboutUs::create([
            'image_1' => '/website/images/151.jpeg',
            'image_2' => '/website/images/151.jpeg',
        ]);

        // إضافة الترجمات
        $aboutUs->setTranslations([
            'ar' => [
                'title' => 'من نحن',
                'description' => '<p>نحن MediaCity، متخصصون في بيع وتأجير معدات التصوير الاحترافية. بدأنا في عام 2019 ولم نتوقف عن التميز منذ ذلك الحين. نحن علامة تجارية عالمية لا تنام، متواجدون على مدار الساعة وطوال أيام الأسبوع، ونقدم دائماً شيئاً جديداً مع أكثر من 100 منتج جديد شهرياً، مما يوفر لك أحدث المعدات بأفضل الأسعار.</p>',
            ],
            'en' => [
                'title' => 'About Us',
                'description' => '<p>We are MediaCity, specialists in selling and renting professional photography equipment. We started in 2019 and haven\'t stopped smashing it since. A global brand that doesn\'t sleep, we are 24/7 and always bringing something new with over 100 new products dropping monthly, bringing you the latest looks for less.</p>',
            ],
        ]);

        // إضافة Features (المميزات)
        $features = [
            [
                'icon' => '/website/svg/3/delivery.svg',
                'translations' => [
                    'ar' => ['title' => 'توصيل مجاني لجميع الطلبات'],
                    'en' => ['title' => 'Free delivery for all orders'],
                ],
            ],
            [
                'icon' => '/website/svg/3/leaf.svg',
                'translations' => [
                    'ar' => ['title' => 'منتجات أصلية فقط'],
                    'en' => ['title' => 'Only authentic products'],
                ],
            ],
            [
                'icon' => '/website/svg/3/delivery.svg',
                'translations' => [
                    'ar' => ['title' => 'خدمة عملاء متميزة'],
                    'en' => ['title' => 'Excellent customer service'],
                ],
            ],
            [
                'icon' => '/website/svg/3/leaf.svg',
                'translations' => [
                    'ar' => ['title' => 'ضمان الجودة'],
                    'en' => ['title' => 'Quality guarantee'],
                ],
            ],
        ];

        foreach ($features as $featureData) {
            $feature = AboutUsFeature::create([
                'about_us_id' => $aboutUs->id,
                'icon' => $featureData['icon'],
            ]);
            $feature->setTranslations($featureData['translations']);
        }

        // إضافة Statistics (الإحصائيات)
        $statistics = [
            [
                'icon' => '/website/svg/3/work.svg',
                'value' => '10',
                'translations' => [
                    'ar' => [
                        'title' => 'سنوات من الخبرة',
                        'description' => 'نحن متخصصون في بيع وتأجير معدات التصوير الاحترافية منذ أكثر من 10 سنوات.',
                    ],
                    'en' => [
                        'title' => 'Business Years',
                        'description' => 'We have been specializing in selling and renting professional photography equipment for over 10 years.',
                    ],
                ],
            ],
            [
                'icon' => '/website/svg/3/buy.svg',
                'value' => '80 K+',
                'translations' => [
                    'ar' => [
                        'title' => 'مبيعات المنتجات',
                        'description' => 'لقد قمنا ببيع وتأجير أكثر من 80 ألف منتج لعملائنا المميزين.',
                    ],
                    'en' => [
                        'title' => 'Products Sales',
                        'description' => 'We have sold and rented over 80,000 products to our valued customers.',
                    ],
                ],
            ],
            [
                'icon' => '/website/svg/3/user.svg',
                'value' => '90%',
                'translations' => [
                    'ar' => [
                        'title' => 'عملاء سعداء',
                        'description' => 'نحن فخورون بأن 90% من عملائنا راضون عن خدماتنا ومنتجاتنا.',
                    ],
                    'en' => [
                        'title' => 'Happy Customers',
                        'description' => 'We are proud that 90% of our customers are satisfied with our services and products.',
                    ],
                ],
            ],
        ];

        foreach ($statistics as $statisticData) {
            $statistic = AboutUsStatistic::create([
                'about_us_id' => $aboutUs->id,
                'icon' => $statisticData['icon'],
                'value' => $statisticData['value'],
            ]);
            $statistic->setTranslations($statisticData['translations']);
        }
    }
}
