<?php

namespace Database\Seeders;


use App\Models\Vision;
use Illuminate\Database\Seeder;

class VisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Vision::truncate();

        $area = Vision::create([
            'id'   => 1,
            'image'   => 'about-us.png',
        ]);

        $area->setTranslations([
            'ar' => [
                'title'       => 'رؤيتنا',
                'description' => 'في [اسم متجرك]، رؤيتنا هي إعادة تعريف مفهوم الموضة الإلكترونية من خلال توفير ملابس أنيقة وعالية الجودة للجميع. نؤمن بأن الموضة وسيلة قوية للتعبير عن الذات، وهدفنا هو تمكين الأفراد من الحصول على ملابس عصرية ومريحة وبأسعار معقولة تعكس شخصيتهم الفريدة وأسلوب حياتهم.

نطمح لأن نكون أكثر من مجرد متجر ملابس، بل نهدف إلى بناء مجتمع أزياء عالمي تزدهر فيه الثقة والإبداع. من خلال تقديم تصاميم جديدة باستمرار، وتبني الاستدامة، وإعطاء الأولوية لرضا العملاء، نسعى جاهدين لوضع معايير جديدة في صناعة الأزياء الإلكترونية.

انضموا إلينا في هذه الرحلة لنرسم مستقبل الموضة، إطلالة تلو الأخرى.',
            ],
            'en' => [
                'title'       => 'Our Vision',
                'description' => 'At [Your Store Name], our vision is to redefine online fashion by making stylish, high-quality clothing accessible to everyone. We believe that fashion is a powerful form of self-expression, and our goal is to empower individuals with trendy, comfortable, and affordable apparel that reflects their unique personality and lifestyle.

We aspire to be more than just a clothing store—we aim to build a global fashion community where confidence and creativity thrive. By continuously curating fresh designs, embracing sustainability, and prioritizing customer satisfaction, we strive to set new standards in the eCommerce fashion industry

Join us on this journey as we shape the future of fashion, one outfit at a time.',
            ],
        ]);

    }
}
