<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        AboutUs::truncate();

        $area = AboutUs::create([
            'id'   => 1,
            'image'   => 'vision.png',
        ]);

        $area->setTranslations([
            'ar' => [
                'title'       => 'مرحباً بكم في متجرنا',
                'description' => 'أهلاً بكم في [اسم متجرك]، وجهتكم المثالية للأزياء الأنيقة عالية الجودة. نؤمن بأن الملابس ليست مجرد قماش، بل هي تعبير عن التفرد والثقة والأناقة. ولذلك، نحرص على اختيار مجموعة تجمع بين أحدث الصيحات والكلاسيكية الخالدة، لنضمن لكم دائماً الإطلالة المثالية لأي مناسبة.

في [اسم متجرك]، نلتزم بتقديم ملابس فاخرة بأسعار معقولة. من الملابس الكاجوال إلى الأزياء الأنيقة، تُلبي مجموعتنا المتنوعة احتياجات عشاق الموضة من جميع الأذواق والأنماط.

الجودة ورضا العملاء هما أساس كل ما نقوم به. نستورد منتجاتنا من مصنّعين موثوقين، مما يضمن جودة الصنع والراحة الفائقة. موقعنا الإلكتروني سهل الاستخدام، والدفع الآمن، والشحن السريع يجعل التسوق معنا سلساً وممتعاً.

انضموا إلى مجتمعنا المتنامي من عشاق الموضة الذين يثقون بـ [اسم متجرك] لتلبية احتياجات خزانة ملابسهم.',
            ],
            'en' => [
                'title'       => 'Welcome to Our Store',
                'description' => 'Welcome to [Your Store Name], your go-to destination for stylish, high-quality fashion. We believe that clothing is more than just fabric—it’s an expression of individuality, confidence, and style. That’s why we curate a collection that blends the latest trends with timeless classics, ensuring you always find the perfect look for any occasion.

At [Your Store Name], we are committed to offering premium clothing at affordable prices. From casual wear to elegant outfits, our diverse range caters to fashion enthusiasts of all styles and preferences.

Quality and customer satisfaction are at the heart of everything we do. We source our products from trusted manufacturers, ensuring superior craftsmanship and comfort. Our user-friendly website, secure checkout, and fast shipping make shopping with us seamless and enjoyable.

Join our growing community of fashion-forward individuals who trust [Your Store Name] for their wardrobe needs.',
            ],
        ]);

    }
}
