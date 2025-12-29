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
                'title_ar' => 'خواتم',
                'title_en' => 'Rings',
            ],
            [
                'title_ar' => 'سلاسل',
                'title_en' => 'Necklaces',
            ],
            [
                'title_ar' => 'أساور',
                'title_en' => 'Bracelets',
            ],
            [
                'title_ar' => 'أطقم ذهب',
                'title_en' => 'Gold Sets',
            ],
            [
                'title_ar' => 'حلقان',
                'title_en' => 'Earrings',
            ],
            [
                'title_ar' => 'سبائك ذهب',
                'title_en' => 'Gold Bars',
            ],
            [
                'title_ar' => 'نصائح الاستثمار',
                'title_en' => 'Investment Tips',
            ],
            [
                'title_ar' => 'العناية بالمجوهرات',
                'title_en' => 'Jewelry Care',
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
            'image' => '19.jpg',
            'category_id' => $categories[1] ?? 1,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'خواتم ذهب فاخرة',
                'description' => '<p>اكتشف تشكيلتنا المميزة من الخواتم الذهبية التي تعكس الأناقة والجمال. نحن نقدم مجموعة واسعة من التصاميم العصرية والكلاسيكية التي تناسب جميع الأذواق.</p><p>جميع خواتمنا مصنوعة من الذهب عيار 21 و 18 قيراط، مما يضمن الجودة العالية والمتانة.</p>',
                'slug' => Str::slug('خواتم ذهب فاخرة'),
                'keywords' => ['خواتم', 'ذهب', 'مجوهرات', 'خواتم ذهب', 'خواتم فاخرة']
            ],
            'en' => [
                'title' => 'Luxury Gold Rings',
                'description' => '<p>Discover our exclusive collection of gold rings that reflect elegance and beauty. We offer a wide range of modern and classic designs that suit all tastes.</p><p>All our rings are made from 21 and 18 karat gold, ensuring high quality and durability.</p>',
                'slug' => Str::slug('Luxury Gold Rings'),
                'keywords' => ['rings', 'gold', 'jewelry', 'gold rings', 'luxury rings']
            ],
        ]);

        // 2
        $article = Article::create([
            'image' => '19.jpg',
            'category_id' => $categories[2] ?? 2,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'سلاسل ذهب عصرية',
                'description' => '<p>سلاسل تناسب جميع المناسبات وتضيف لمسة فريدة لمظهرك. من التصاميم الكلاسيكية إلى العصرية، لدينا ما يناسبك.</p><p>جميع السلاسل مصنوعة يدوياً بعناية فائقة لضمان الجودة والأناقة.</p>',
                'slug' => Str::slug('سلاسل ذهب عصرية'),
                'keywords' => ['سلاسل', 'ذهب', 'قلائد', 'سلاسل ذهب', 'مجوهرات']
            ],
            'en' => [
                'title' => 'Trendy Gold Necklaces',
                'description' => '<p>Necklaces for all occasions that add a unique touch to your look. From classic to modern designs, we have something for you.</p><p>All necklaces are handcrafted with great care to ensure quality and elegance.</p>',
                'slug' => Str::slug('Trendy Gold Necklaces'),
                'keywords' => ['necklaces', 'gold', 'chains', 'gold necklaces', 'jewelry']
            ],
        ]);

        // 3
        $article = Article::create([
            'image' => '19.jpg',
            'category_id' => $categories[3] ?? 3,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'أساور ذهب أنيقة',
                'description' => '<p>أساور مصممة بعناية لتمنحك إطلالة راقية. تصاميم متنوعة تناسب جميع الأذواق والمناسبات.</p><p>جميع الأساور مصنوعة من الذهب الخالص مع ضمان الجودة والأناقة.</p>',
                'slug' => Str::slug('أساور ذهب أنيقة'),
                'keywords' => ['أساور', 'ذهب', 'مجوهرات', 'أساور ذهب', 'إطلالة راقية']
            ],
            'en' => [
                'title' => 'Elegant Gold Bracelets',
                'description' => '<p>Carefully crafted bracelets that give you a sophisticated look. Various designs to suit all tastes and occasions.</p><p>All bracelets are made from pure gold with quality and elegance guaranteed.</p>',
                'slug' => Str::slug('Elegant Gold Bracelets'),
                'keywords' => ['bracelets', 'gold', 'jewelry', 'gold bracelets', 'elegant']
            ],
        ]);

        // 4
        $article = Article::create([
            'image' => '19.jpg',
            'category_id' => $categories[4] ?? 4,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'أطقم ذهب كاملة',
                'description' => '<p>تميزي مع أطقم ذهبية متكاملة تناسب المناسبات الخاصة. أطقم مصممة بعناية لتكون متناسقة ومتكاملة.</p><p>جميع الأطقم تشمل خاتم وسلسلة وأساور متناسقة في التصميم.</p>',
                'slug' => Str::slug('أطقم ذهب كاملة'),
                'keywords' => ['أطقم', 'ذهب', 'مجوهرات', 'أطقم ذهب', 'مناسبات خاصة']
            ],
            'en' => [
                'title' => 'Complete Gold Sets',
                'description' => '<p>Stand out with complete gold sets perfect for special occasions. Carefully designed sets that are harmonious and complete.</p><p>All sets include matching ring, necklace, and bracelets in design.</p>',
                'slug' => Str::slug('Complete Gold Sets'),
                'keywords' => ['sets', 'gold', 'jewelry', 'gold sets', 'special occasions']
            ],
        ]);

        // 5
        $article = Article::create([
            'image' => '19.jpg',
            'category_id' => $categories[6] ?? 6,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'الاستثمار في السبائك',
                'description' => '<p>تعرف على فوائد الاستثمار في سبائك الذهب كخيار آمن. الذهب يعتبر من أفضل الاستثمارات على المدى الطويل.</p><p>السبائك الذهبية تحافظ على قيمتها وتزداد مع مرور الوقت، مما يجعلها خياراً مثالياً للاستثمار.</p>',
                'slug' => Str::slug('الاستثمار في السبائك'),
                'keywords' => ['استثمار', 'سبائك', 'ذهب', 'استثمار آمن', 'سبائك ذهب']
            ],
            'en' => [
                'title' => 'Investing in Gold Bars',
                'description' => '<p>Learn about the benefits of investing in gold bars as a safe option. Gold is considered one of the best long-term investments.</p><p>Gold bars maintain their value and increase over time, making them an ideal investment choice.</p>',
                'slug' => Str::slug('Investing in Gold Bars'),
                'keywords' => ['investment', 'bars', 'gold', 'safe investment', 'gold bars']
            ],
        ]);

        // 6
        $article = Article::create([
            'image' => '19.jpg',
            'category_id' => $categories[8] ?? 8,
            'status' => 1
        ]);
        $article->setTranslations([
            'ar' => [
                'title' => 'العناية بمجوهراتك الذهبية',
                'description' => '<p>نصائح للحفاظ على لمعان وبريق الذهب لأطول فترة ممكنة. العناية الصحيحة بالمجوهرات الذهبية تطيل عمرها وتحافظ على جمالها.</p><p>تجنب تعريض الذهب للمواد الكيميائية والمنظفات القوية. نظف المجوهرات بقطعة قماش ناعمة وماء دافئ.</p>',
                'slug' => Str::slug('العناية بمجوهراتك الذهبية'),
                'keywords' => ['عناية', 'مجوهرات', 'ذهب', 'نصائح', 'صيانة مجوهرات']
            ],
            'en' => [
                'title' => 'Caring for Your Gold Jewelry',
                'description' => '<p>Tips to maintain the shine and brilliance of gold for longer. Proper care of gold jewelry extends its life and maintains its beauty.</p><p>Avoid exposing gold to chemicals and strong detergents. Clean jewelry with a soft cloth and warm water.</p>',
                'slug' => Str::slug('Caring for Your Gold Jewelry'),
                'keywords' => ['care', 'jewelry', 'gold', 'tips', 'jewelry maintenance']
            ],
        ]);
    }
}
