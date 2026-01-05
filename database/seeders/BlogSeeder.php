<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data - disable foreign key checks temporarily
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('article_article_tag')->truncate();
        \DB::table('article_slug_redirects')->truncate();
        \DB::table('sys_language_translations')->where('model_type', Article::class)->delete();
        \DB::table('sys_language_translations')->where('model_type', ArticleCategory::class)->delete();
        Article::truncate();
        ArticleCategory::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $blogCategorises = [
            [
                'title_ar' => 'كاميرات تصوير',
                'title_en' => 'Cameras',
            ],
            [
                'title_ar' => 'إكسسوارات التصوير',
                'title_en' => 'Photography Accessories',
            ],
            [
                'title_ar' => 'تأجير كاميرات',
                'title_en' => 'Camera Rental',
            ],
            [
                'title_ar' => 'استوديوهات التصوير',
                'title_en' => 'Photography Studios',
            ],
            [
                'title_ar' => 'عدسات التصوير',
                'title_en' => 'Camera Lenses',
            ],
            [
                'title_ar' => 'معدات الإضاءة',
                'title_en' => 'Lighting Equipment',
            ],
            [
                'title_ar' => 'نصائح التصوير',
                'title_en' => 'Photography Tips',
            ],
            [
                'title_ar' => 'شراكات',
                'title_en' => 'Partnerships',
            ],
        ];


        $categories = [];
        foreach ($blogCategorises as $index => $category) {
            $articleCategory = ArticleCategory::create([
                'status' => 1
            ]);
            $articleCategory->setTranslations([
                'ar' => [
                    'title' => $category['title_ar'],
                ],
                'en' => [
                    'title' => $category['title_en'],
                ],
            ]);
            $categories[$index + 1] = $articleCategory->id;
        }


        // 1
        $article = Article::create([
            'image' => 'blog-1.jpg',
            'category_id' => $categories[1] ?? 1,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'كاميرات تصوير احترافية',
                'description' => '<p>اكتشف مجموعتنا المميزة من الكاميرات الاحترافية التي تلبي احتياجات المصورين المحترفين والهواة. نقدم مجموعة واسعة من الكاميرات الرقمية والمرآة العاكسة من أفضل العلامات التجارية.</p><p>جميع كاميراتنا تتميز بجودة عالية ودقة فائقة في التصوير، مما يضمن الحصول على صور احترافية متميزة.</p>',
                'slug' => Str::slug('كاميرات تصوير احترافية'),
                'keywords' => ['كاميرات', 'تصوير', 'كاميرات احترافية', 'كاميرات رقمية', 'تصوير فوتوغرافي']
            ],
            'en' => [
                'title' => 'Professional Photography Cameras',
                'description' => '<p>Discover our exclusive collection of professional cameras that meet the needs of professional and amateur photographers. We offer a wide range of digital and DSLR cameras from the best brands.</p><p>All our cameras feature high quality and exceptional shooting accuracy, ensuring professional and outstanding photos.</p>',
                'slug' => Str::slug('Professional Photography Cameras'),
                'keywords' => ['cameras', 'photography', 'professional cameras', 'digital cameras', 'photography']
            ],
        ]);

        // 2
        $article = Article::create([
            'image' => 'blog-2.jpg',
            'category_id' => $categories[2] ?? 2,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'إكسسوارات التصوير الاحترافية',
                'description' => '<p>إكسسوارات تصوير عالية الجودة تناسب جميع احتياجات المصورين. من الحاملات الثلاثية إلى الحقائب والبطاريات الاحتياطية، لدينا كل ما تحتاجه.</p><p>جميع إكسسواراتنا مصنوعة من مواد عالية الجودة لضمان المتانة والأداء المتميز.</p>',
                'slug' => Str::slug('إكسسوارات التصوير الاحترافية'),
                'keywords' => ['إكسسوارات', 'تصوير', 'معدات تصوير', 'حاملات ثلاثية', 'إكسسوارات كاميرات']
            ],
            'en' => [
                'title' => 'Professional Photography Accessories',
                'description' => '<p>High-quality photography accessories that meet all photographers\' needs. From tripods to bags and spare batteries, we have everything you need.</p><p>All our accessories are made from high-quality materials to ensure durability and excellent performance.</p>',
                'slug' => Str::slug('Professional Photography Accessories'),
                'keywords' => ['accessories', 'photography', 'photography equipment', 'tripods', 'camera accessories']
            ],
        ]);

        // 3
        $article = Article::create([
            'image' => 'blog-3.jpg',
            'category_id' => $categories[3] ?? 3,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'تأجير كاميرات للاستوديوهات',
                'description' => '<p>خدمة تأجير كاميرات احترافية للاستوديوهات والمصورين. نوفر مجموعة واسعة من الكاميرات والمعدات الاحترافية بأسعار تنافسية.</p><p>جميع الكاميرات المعروضة للتأجير في حالة ممتازة ومجهزة بجميع الإكسسوارات اللازمة لضمان جودة التصوير.</p>',
                'slug' => Str::slug('تأجير كاميرات للاستوديوهات'),
                'keywords' => ['تأجير', 'كاميرات', 'استوديو', 'تأجير كاميرات', 'معدات تصوير']
            ],
            'en' => [
                'title' => 'Camera Rental for Studios',
                'description' => '<p>Professional camera rental service for studios and photographers. We offer a wide range of professional cameras and equipment at competitive prices.</p><p>All cameras available for rent are in excellent condition and equipped with all necessary accessories to ensure quality photography.</p>',
                'slug' => Str::slug('Camera Rental for Studios'),
                'keywords' => ['rental', 'cameras', 'studio', 'camera rental', 'photography equipment']
            ],
        ]);

        // 4
        $article = Article::create([
            'image' => 'blog-4.jpg',
            'category_id' => $categories[4] ?? 4,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'استوديوهات التصوير المجهزة',
                'description' => '<p>استوديوهات تصوير مجهزة بالكامل بجميع المعدات اللازمة للتصوير الاحترافي. إضاءة احترافية وخلفيات متنوعة ومعدات متكاملة.</p><p>جميع الاستوديوهات مجهزة بأحدث المعدات والتقنيات لضمان الحصول على أفضل النتائج في التصوير.</p>',
                'slug' => Str::slug('استوديوهات التصوير المجهزة'),
                'keywords' => ['استوديو', 'تصوير', 'استوديوهات', 'تصوير احترافي', 'معدات استوديو']
            ],
            'en' => [
                'title' => 'Fully Equipped Photography Studios',
                'description' => '<p>Fully equipped photography studios with all necessary equipment for professional photography. Professional lighting, various backgrounds, and integrated equipment.</p><p>All studios are equipped with the latest equipment and technologies to ensure the best photography results.</p>',
                'slug' => Str::slug('Fully Equipped Photography Studios'),
                'keywords' => ['studio', 'photography', 'studios', 'professional photography', 'studio equipment']
            ],
        ]);

        // 5
        $article = Article::create([
            'image' => 'blog-5.jpg',
            'category_id' => $categories[6] ?? 6,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'نصائح التصوير الاحترافي',
                'description' => '<p>تعرف على أفضل النصائح والتقنيات للتصوير الاحترافي. من الإضاءة إلى التكوين، نقدم لك كل ما تحتاج لمعرفته.</p><p>التصوير الاحترافي يتطلب فهم عميق للكاميرات والإضاءة والتقنيات المختلفة للحصول على أفضل النتائج.</p>',
                'slug' => Str::slug('نصائح التصوير الاحترافي'),
                'keywords' => ['نصائح', 'تصوير', 'تصوير احترافي', 'تقنيات تصوير', 'مصورين']
            ],
            'en' => [
                'title' => 'Professional Photography Tips',
                'description' => '<p>Learn the best tips and techniques for professional photography. From lighting to composition, we provide everything you need to know.</p><p>Professional photography requires a deep understanding of cameras, lighting, and various techniques to achieve the best results.</p>',
                'slug' => Str::slug('Professional Photography Tips'),
                'keywords' => ['tips', 'photography', 'professional photography', 'photography techniques', 'photographers']
            ],
        ]);

        // 6
        $article = Article::create([
            'image' => 'blog-6.jpg',
            'category_id' => $categories[8] ?? 8,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'شراكات استراتيجية في مجال التصوير',
                'description' => '<p>نقدم شراكات استراتيجية مع الاستوديوهات والمصورين المحترفين. شراكات متبادلة المنفعة تساعد في تطوير الأعمال وتوسيع نطاق الخدمات.</p><p>نعمل مع أفضل الاستوديوهات والمصورين لتقديم خدمات متكاملة في مجال التصوير والمعدات.</p>',
                'slug' => Str::slug('شراكات استراتيجية في مجال التصوير'),
                'keywords' => ['شراكات', 'تصوير', 'استوديوهات', 'مصورين', 'شراكات استراتيجية']
            ],
            'en' => [
                'title' => 'Strategic Partnerships in Photography',
                'description' => '<p>We offer strategic partnerships with studios and professional photographers. Mutually beneficial partnerships that help develop businesses and expand service scope.</p><p>We work with the best studios and photographers to provide integrated services in photography and equipment.</p>',
                'slug' => Str::slug('Strategic Partnerships in Photography'),
                'keywords' => ['partnerships', 'photography', 'studios', 'photographers', 'strategic partnerships']
            ],
        ]);
    }
}
