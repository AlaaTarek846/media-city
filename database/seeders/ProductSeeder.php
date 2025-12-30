<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductFeature;
use App\Models\DepartmentCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Product::truncate();

        // بيانات المنتجات - كاميرات تصوير واكسسوارات كاميرات
        $productsData = [
            // 5 منتجات جديدة (new)
            [
                'condition' => 'new',
                'brand_id' => 1, // Canon
                'category_id' => 1, // DSLR Cameras
                'title_ar' => 'كاميرا كانون EOS R6',
                'title_en' => 'Canon EOS R6 Camera',
                'description_ar' => 'كاميرا كانون EOS R6 احترافية - كاميرا ميرورلس كاملة الإطار مع معالج DIGIC X ومستشعر CMOS بدقة 20.1 ميجابكسل. مثالية للتصوير الفوتوغرافي والفيديو الاحترافي.',
                'description_en' => 'Canon EOS R6 Professional Camera - Full-frame mirrorless camera with DIGIC X processor and 20.1MP CMOS sensor. Perfect for professional photography and videography.',
                'feature_ar' => 'كاميرا كانون EOS R6 - التصوير الاحترافي في يديك

اكتشف قوة التصوير الاحترافي مع كاميرا كانون EOS R6. هذه الكاميرا الميرورلس كاملة الإطار مصممة للمصورين المحترفين الذين يبحثون عن جودة استثنائية وأداء فائق.

الميزات:
معالج DIGIC X القوي
مستشعر CMOS بدقة 20.1 ميجابكسل
تثبيت صورة مزدوج 5 محاور
تصوير فيديو 4K بجودة عالية
شاشة LCD قابلة للطي واللمس
مقاومة الطقس والغبار',
                'feature_en' => 'Canon EOS R6 - Professional Photography in Your Hands

Discover the power of professional photography with the Canon EOS R6. This full-frame mirrorless camera is designed for professional photographers seeking exceptional quality and outstanding performance.

Features:
Powerful DIGIC X processor
20.1MP CMOS sensor
5-axis dual image stabilization
4K high-quality video recording
Foldable and touch LCD screen
Weather and dust resistant',
            ],
            [
                'condition' => 'new',
                'brand_id' => 2, // Nikon
                'category_id' => 2, // Mirrorless Cameras
                'title_ar' => 'كاميرا نيكون Z7 II',
                'title_en' => 'Nikon Z7 II Camera',
                'description_ar' => 'كاميرا نيكون Z7 II ميرورلس بدقة 45.7 ميجابكسل - كاميرا احترافية بتقنية متقدمة للتصوير الفوتوغرافي عالي الجودة.',
                'description_en' => 'Nikon Z7 II Mirrorless Camera with 45.7MP resolution - Professional camera with advanced technology for high-quality photography.',
                'feature_ar' => 'كاميرا نيكون Z7 II - الدقة والوضوح

كاميرا ميرورلس احترافية بدقة 45.7 ميجابكسل توفر جودة استثنائية في كل لقطة. مثالية للمصورين المحترفين والهواة المتقدمين.

الميزات:
دقة 45.7 ميجابكسل
معالج EXPEED 6 مزدوج
نطاق ISO واسع حتى 64000
تثبيت صورة مدمج 5 محاور
تصوير فيديو 4K UHD
شاشة OLED عالية الجودة',
                'feature_en' => 'Nikon Z7 II - Precision and Clarity

Professional mirrorless camera with 45.7MP resolution delivering exceptional quality in every shot. Perfect for professional photographers and advanced enthusiasts.

Features:
45.7MP resolution
Dual EXPEED 6 processor
Wide ISO range up to 64000
5-axis built-in image stabilization
4K UHD video recording
High-quality OLED screen',
            ],
            [
                'condition' => 'new',
                'brand_id' => 3, // Sony
                'category_id' => 3, // Video Cameras
                'title_ar' => 'كاميرا سوني FX3 للفيديو',
                'title_en' => 'Sony FX3 Video Camera',
                'description_ar' => 'كاميرا سوني FX3 احترافية للفيديو - كاميرا سينمائية كاملة الإطار مع تسجيل 4K بجودة عالية وتقنيات متقدمة.',
                'description_en' => 'Sony FX3 Professional Video Camera - Full-frame cinema camera with 4K high-quality recording and advanced technologies.',
                'feature_ar' => 'كاميرا سوني FX3 - السينما في يديك

كاميرا فيديو احترافية كاملة الإطار مصممة لصناع المحتوى والمخرجين السينمائيين. توفر جودة سينمائية استثنائية.

الميزات:
مستشعر كامل الإطار 12.1 ميجابكسل
تسجيل فيديو 4K بجودة عالية
تثبيت صورة نشط 5 محاور
نطاق ديناميكي واسع S-Log3
مقاومة الطقس
تصميم مضغوط وخفيف',
                'feature_en' => 'Sony FX3 - Cinema in Your Hands

Professional full-frame video camera designed for content creators and cinema directors. Delivers exceptional cinematic quality.

Features:
12.1MP full-frame sensor
4K high-quality video recording
5-axis active image stabilization
Wide dynamic range S-Log3
Weather resistant
Compact and lightweight design',
            ],
            [
                'condition' => 'new',
                'brand_id' => 9, // Sigma
                'category_id' => 4, // Lenses
                'title_ar' => 'عدسة سيجما 24-70mm f/2.8',
                'title_en' => 'Sigma 24-70mm f/2.8 Lens',
                'description_ar' => 'عدسة سيجما 24-70mm f/2.8 DG OS HSM - عدسة زووم احترافية بفتحة عدسة ثابتة f/2.8 مثالية للتصوير الفوتوغرافي العام.',
                'description_en' => 'Sigma 24-70mm f/2.8 DG OS HSM Lens - Professional zoom lens with constant f/2.8 aperture perfect for general photography.',
                'feature_ar' => 'عدسة سيجما 24-70mm f/2.8 - المرونة والجودة

عدسة زووم احترافية بفتحة عدسة ثابتة توفر مرونة استثنائية وجودة بصرية عالية. مثالية لجميع أنواع التصوير.

الميزات:
نطاق بؤري 24-70mm
فتحة عدسة ثابتة f/2.8
تثبيت صورة بصري
تصميم مقاوم للماء والغبار
جودة بصرية استثنائية
مناسبة للتصوير العام والاحترافي',
                'feature_en' => 'Sigma 24-70mm f/2.8 - Flexibility and Quality

Professional zoom lens with constant aperture providing exceptional flexibility and high optical quality. Perfect for all types of photography.

Features:
24-70mm focal range
Constant f/2.8 aperture
Optical image stabilization
Water and dust resistant design
Exceptional optical quality
Suitable for general and professional photography',
            ],
            [
                'condition' => 'new',
                'brand_id' => 6, // Manfrotto
                'category_id' => 6, // Tripods & Stands
                'title_ar' => 'حامل مانفروتو بيكو 190X',
                'title_en' => 'Manfrotto Befree 190X Tripod',
                'description_ar' => 'حامل مانفروتو بيكو 190X ثلاثي القوائم - حامل احترافي قابل للطي خفيف الوزن ومتين للتصوير الفوتوغرافي والفيديو.',
                'description_en' => 'Manfrotto Befree 190X Tripod - Professional lightweight and sturdy foldable tripod for photography and videography.',
                'feature_ar' => 'حامل مانفروتو بيكو 190X - الاستقرار والتنقل

حامل ثلاثي القوائم احترافي يجمع بين المتانة والتنقل. مثالي للمصورين المحترفين والهواة.

الميزات:
قابل للطي بشكل مضغوط
خفيف الوزن وسهل الحمل
متين ومستقر
ارتفاع قابل للتعديل
رأس كرة سلسة
مقاوم للاهتزازات',
                'feature_en' => 'Manfrotto Befree 190X - Stability and Mobility

Professional tripod that combines durability and portability. Perfect for professional and amateur photographers.

Features:
Compact foldable design
Lightweight and easy to carry
Sturdy and stable
Adjustable height
Smooth ball head
Vibration resistant',
            ],
            // 5 منتجات مستعملة (used)
            [
                'condition' => 'used',
                'brand_id' => 1, // Canon
                'category_id' => 1, // DSLR Cameras
                'title_ar' => 'كاميرا كانون EOS 5D Mark IV مستعملة',
                'title_en' => 'Used Canon EOS 5D Mark IV Camera',
                'description_ar' => 'كاميرا كانون EOS 5D Mark IV مستعملة بحالة جيدة - كاميرا DSLR احترافية بدقة 30.4 ميجابكسل مع معالج DIGIC 6+.',
                'description_en' => 'Used Canon EOS 5D Mark IV Camera in good condition - Professional DSLR camera with 30.4MP resolution and DIGIC 6+ processor.',
                'feature_ar' => 'كاميرا كانون EOS 5D Mark IV مستعملة - جودة احترافية

كاميرا DSLR احترافية مستعملة بحالة ممتازة. توفر أداءً استثنائياً وجودة صور عالية للمصورين المحترفين.

الميزات:
دقة 30.4 ميجابكسل
معالج DIGIC 6+
نطاق ISO 100-32000
تسجيل فيديو 4K
شاشة LCD عالية الجودة
مقاومة الطقس
حالة جيدة جداً',
                'feature_en' => 'Used Canon EOS 5D Mark IV - Professional Quality

Used professional DSLR camera in excellent condition. Delivers exceptional performance and high image quality for professional photographers.

Features:
30.4MP resolution
DIGIC 6+ processor
ISO range 100-32000
4K video recording
High-quality LCD screen
Weather resistant
Very good condition',
            ],
            [
                'condition' => 'used',
                'brand_id' => 2, // Nikon
                'category_id' => 4, // Lenses
                'title_ar' => 'عدسة نيكون 70-200mm f/2.8 مستعملة',
                'title_en' => 'Used Nikon 70-200mm f/2.8 Lens',
                'description_ar' => 'عدسة نيكون 70-200mm f/2.8 VR مستعملة بحالة جيدة - عدسة زووم تليفوتوغرافية احترافية بفتحة عدسة ثابتة.',
                'description_en' => 'Used Nikon 70-200mm f/2.8 VR Lens in good condition - Professional telephoto zoom lens with constant aperture.',
                'feature_ar' => 'عدسة نيكون 70-200mm f/2.8 مستعملة - بُعد بؤري احترافي

عدسة تليفوتوغرافية احترافية مستعملة بحالة ممتازة. مثالية للتصوير الرياضي والبرية والبورتريه.

الميزات:
نطاق بؤري 70-200mm
فتحة عدسة ثابتة f/2.8
تثبيت صورة VR
جودة بصرية استثنائية
تصميم مقاوم للماء
حالة جيدة جداً',
                'feature_en' => 'Used Nikon 70-200mm f/2.8 - Professional Focal Length

Used professional telephoto lens in excellent condition. Perfect for sports, wildlife, and portrait photography.

Features:
70-200mm focal range
Constant f/2.8 aperture
VR image stabilization
Exceptional optical quality
Water resistant design
Very good condition',
            ],
            [
                'condition' => 'used',
                'brand_id' => 3, // Sony
                'category_id' => 2, // Mirrorless Cameras
                'title_ar' => 'كاميرا سوني A7 III مستعملة',
                'title_en' => 'Used Sony A7 III Camera',
                'description_ar' => 'كاميرا سوني A7 III ميرورلس مستعملة بحالة جيدة - كاميرا كاملة الإطار بدقة 24.2 ميجابكسل مع معالج BIONZ X.',
                'description_en' => 'Used Sony A7 III Mirrorless Camera in good condition - Full-frame camera with 24.2MP resolution and BIONZ X processor.',
                'feature_ar' => 'كاميرا سوني A7 III مستعملة - أداء استثنائي

كاميرا ميرورلس كاملة الإطار مستعملة بحالة ممتازة. توفر توازناً مثالياً بين الجودة والأداء.

الميزات:
دقة 24.2 ميجابكسل
معالج BIONZ X
تثبيت صورة 5 محاور
تسجيل فيديو 4K
شاشة OLED عالية الجودة
بطارية طويلة الأمد
حالة جيدة جداً',
                'feature_en' => 'Used Sony A7 III - Exceptional Performance

Used full-frame mirrorless camera in excellent condition. Provides perfect balance between quality and performance.

Features:
24.2MP resolution
BIONZ X processor
5-axis image stabilization
4K video recording
High-quality OLED screen
Long battery life
Very good condition',
            ],
            [
                'condition' => 'used',
                'brand_id' => 7, // Rode
                'category_id' => 8, // Microphones
                'title_ar' => 'ميكروفون رود VideoMic Pro+ مستعمل',
                'title_en' => 'Used Rode VideoMic Pro+ Microphone',
                'description_ar' => 'ميكروفون رود VideoMic Pro+ مستعمل بحالة جيدة - ميكروفون بندقية احترافي للفيديو مع تقنية Rycote Lyre.',
                'description_en' => 'Used Rode VideoMic Pro+ Microphone in good condition - Professional shotgun microphone for video with Rycote Lyre technology.',
                'feature_ar' => 'ميكروفون رود VideoMic Pro+ مستعمل - صوت احترافي

ميكروفون بندقية احترافي مستعمل بحالة ممتازة. يوفر جودة صوت عالية للفيديو والمحتوى.

الميزات:
تقنية Rycote Lyre
تقليل الضوضاء المحيطة
بطارية قابلة لإعادة الشحن
مستوى صوت قابل للتعديل
تصميم مضغوط
حالة جيدة جداً',
                'feature_en' => 'Used Rode VideoMic Pro+ - Professional Sound

Used professional shotgun microphone in excellent condition. Delivers high audio quality for video and content.

Features:
Rycote Lyre technology
Ambient noise reduction
Rechargeable battery
Adjustable audio level
Compact design
Very good condition',
            ],
            [
                'condition' => 'used',
                'brand_id' => 8, // Godox
                'category_id' => 5, // Lighting Equipment
                'title_ar' => 'إضاءة جودوكس AD200 Pro مستعملة',
                'title_en' => 'Used Godox AD200 Pro Flash',
                'description_ar' => 'إضاءة جودوكس AD200 Pro مستعملة بحالة جيدة - فلاش احترافي قابل للشحن بقوة 200 وات/ثانية مع تقنية TTL.',
                'description_en' => 'Used Godox AD200 Pro Flash in good condition - Professional rechargeable flash with 200 Ws power and TTL technology.',
                'feature_ar' => 'إضاءة جودوكس AD200 Pro مستعملة - إضاءة احترافية

فلاش احترافي مستعمل بحالة ممتازة. يوفر إضاءة قوية ومرنة للتصوير الفوتوغرافي الاحترافي.

الميزات:
قوة 200 وات/ثانية
تقنية TTL
بطارية قابلة لإعادة الشحن
وقت إعادة الشحن سريع
تصميم مضغوط
حالة جيدة جداً',
                'feature_en' => 'Used Godox AD200 Pro - Professional Lighting

Used professional flash in excellent condition. Provides powerful and flexible lighting for professional photography.

Features:
200 Ws power
TTL technology
Rechargeable battery
Fast recycle time
Compact design
Very good condition',
            ],
        ];

        // إنشاء المنتجات
        foreach ($productsData as $index => $productData) {
            $productNumber = $index + 1;

            // الحصول على department_category_id من جدول DepartmentCategory
            $departmentCategory = DepartmentCategory::where('department_id', 2)
                ->where('category_id', $productData['category_id'])
                ->first();

            $product = Product::create([
                'image'                   => "buy{$productNumber}.jpg",
                "department_id"           => 2,
                'brand_id'                => $productData['brand_id'],
                'category_id'             => $productData['category_id'],
                "department_category_id"  => $departmentCategory ? $departmentCategory->id : null,
                'type'                    => 'standard',
                'condition'               => $productData['condition'],
                'status'                  => 1,
            ]);

            $product->setTranslations([
                'ar' => [
                    'title' => $productData['title_ar'],
                    'description' => $productData['description_ar'],
                ],
                'en' => [
                    'title'       => $productData['title_en'],
                    'description' => $productData['description_en'],
                ],
            ]);

            $skuNumber = str_pad($productNumber, 3, '0', STR_PAD_LEFT);
            $product->variant()->create([
                'sku' => "CAM-{$skuNumber}",
                'attribute_values' => '',
                'price_before_discount' => 5000 + ($productNumber * 100),
                'discount_percentage' => $productData['condition'] === 'used' ? 15 : 10,
                'price' => $productData['condition'] === 'used'
                    ? (5000 + ($productNumber * 100)) * 0.85
                    : (5000 + ($productNumber * 100)) * 0.9,
                'quantity' => $productData['condition'] === 'used' ? 1 : 10,
                'status' => 1,
            ]);

            $product->images()->create([
                'image' => "product-1.jpg",
            ]);
            $product->images()->create([
                'image' => "product-2.jpg",
            ]);
            $product->images()->create([
                'image' => "product-3.jpg",
            ]);
            $product->images()->create([
                'image' => "product-4.jpg",
            ]);
            $product->images()->create([
                'image' => "product-5.jpg",
            ]);

            $product_feature = ProductFeature::create([
                'product_id' => $product->id,
            ]);
            $product_feature->setTranslations([
                'ar' => [
                    'title' => 'ميزات المنتج',
                    'description' => $productData['feature_ar'],
                ],
                'en' => [
                    'title'       => 'Product Features',
                    'description' => $productData['feature_en'],
                ],
            ]);
        }

        // بيانات المنتجات للإيجار - كاميرات تصوير واكسسوارات كاميرات
        $rentProductsData = [
            [
                'condition' => 'rent',
                'brand_id' => 1,
                'category_id' => 1,
                'title_ar' => 'إيجار كاميرا كانون EOS R5',
                'title_en' => 'Rent Canon EOS R5 Camera',
                'description_ar' => 'إيجار كاميرا كانون EOS R5 احترافية - كاميرا ميرورلس كاملة الإطار بدقة 45 ميجابكسل مع تسجيل فيديو 8K. مثالية للمشاريع الاحترافية.',
                'description_en' => 'Rent Canon EOS R5 Professional Camera - Full-frame mirrorless camera with 45MP resolution and 8K video recording. Perfect for professional projects.',
                'feature_ar' => 'إيجار كاميرا كانون EOS R5 - التصوير الاحترافي

كاميرا ميرورلس احترافية للإيجار بدقة 45 ميجابكسل. مثالية للمصورين المحترفين ومصوري الفيديو.

الميزات:
دقة 45 ميجابكسل
تسجيل فيديو 8K
تثبيت صورة مزدوج 5 محاور
معالج DIGIC X
شاشة LCD قابلة للطي واللمس
مقاومة الطقس والغبار',
                'feature_en' => 'Rent Canon EOS R5 - Professional Photography

Professional mirrorless camera for rent with 45MP resolution. Perfect for professional photographers and videographers.

Features:
45MP resolution
8K video recording
5-axis dual image stabilization
DIGIC X processor
Foldable and touch LCD screen
Weather and dust resistant',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 2,
                'category_id' => 2,
                'title_ar' => 'إيجار كاميرا نيكون Z9',
                'title_en' => 'Rent Nikon Z9 Camera',
                'description_ar' => 'إيجار كاميرا نيكون Z9 احترافية - كاميرا ميرورلس كاملة الإطار بدقة 45.7 ميجابكسل مع تسجيل فيديو 8K وتقنيات متقدمة.',
                'description_en' => 'Rent Nikon Z9 Professional Camera - Full-frame mirrorless camera with 45.7MP resolution and 8K video recording with advanced technologies.',
                'feature_ar' => 'إيجار كاميرا نيكون Z9 - الأداء الاحترافي

كاميرا ميرورلس احترافية للإيجار بدقة 45.7 ميجابكسل. توفر أداءً استثنائياً للمصورين المحترفين.

الميزات:
دقة 45.7 ميجابكسل
تسجيل فيديو 8K
معالج EXPEED 7
تثبيت صورة مدمج 5 محاور
شاشة OLED عالية الجودة
بطارية طويلة الأمد',
                'feature_en' => 'Rent Nikon Z9 - Professional Performance

Professional mirrorless camera for rent with 45.7MP resolution. Delivers exceptional performance for professional photographers.

Features:
45.7MP resolution
8K video recording
EXPEED 7 processor
5-axis built-in image stabilization
High-quality OLED screen
Long battery life',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 3,
                'category_id' => 9,
                'title_ar' => 'إيجار كاميرا سوني FX6 للسينما',
                'title_en' => 'Rent Sony FX6 Cinema Camera',
                'description_ar' => 'إيجار كاميرا سوني FX6 سينمائية احترافية - كاميرا فيديو كاملة الإطار مع تسجيل 4K بجودة عالية وتقنيات سينمائية متقدمة.',
                'description_en' => 'Rent Sony FX6 Professional Cinema Camera - Full-frame video camera with 4K high-quality recording and advanced cinematic technologies.',
                'feature_ar' => 'إيجار كاميرا سوني FX6 - السينما الاحترافية

كاميرا سينمائية احترافية للإيجار. مصممة للمخرجين السينمائيين وصناع المحتوى المحترفين.

الميزات:
مستشعر كامل الإطار
تسجيل فيديو 4K بجودة عالية
تثبيت صورة نشط 5 محاور
نطاق ديناميكي واسع S-Log3
مقاومة الطقس
تصميم احترافي',
                'feature_en' => 'Rent Sony FX6 - Professional Cinema

Professional cinema camera for rent. Designed for cinema directors and professional content creators.

Features:
Full-frame sensor
4K high-quality video recording
5-axis active image stabilization
Wide dynamic range S-Log3
Weather resistant
Professional design',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 4,
                'category_id' => 3,
                'title_ar' => 'إيجار كاميرا باناسونيك GH6',
                'title_en' => 'Rent Panasonic GH6 Camera',
                'description_ar' => 'إيجار كاميرا باناسونيك GH6 للفيديو - كاميرا ميرورلس بدقة 25.2 ميجابكسل مع تسجيل فيديو 5.7K وتقنيات متقدمة.',
                'description_en' => 'Rent Panasonic GH6 Video Camera - Mirrorless camera with 25.2MP resolution and 5.7K video recording with advanced technologies.',
                'feature_ar' => 'إيجار كاميرا باناسونيك GH6 - الفيديو الاحترافي

كاميرا فيديو احترافية للإيجار. مثالية لصناع المحتوى والمصورين المحترفين.

الميزات:
دقة 25.2 ميجابكسل
تسجيل فيديو 5.7K
تثبيت صورة مزدوج 5 محاور
شاشة LCD قابلة للطي
مقاومة الطقس
تصميم مضغوط',
                'feature_en' => 'Rent Panasonic GH6 - Professional Video

Professional video camera for rent. Perfect for content creators and professional photographers.

Features:
25.2MP resolution
5.7K video recording
5-axis dual image stabilization
Foldable LCD screen
Weather resistant
Compact design',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 9,
                'category_id' => 4,
                'title_ar' => 'إيجار عدسة سيجما 85mm f/1.4',
                'title_en' => 'Rent Sigma 85mm f/1.4 Lens',
                'description_ar' => 'إيجار عدسة سيجما 85mm f/1.4 DG HSM - عدسة بورتريه احترافية بفتحة عدسة واسعة مثالية للتصوير الاحترافي.',
                'description_en' => 'Rent Sigma 85mm f/1.4 DG HSM Lens - Professional portrait lens with wide aperture perfect for professional photography.',
                'feature_ar' => 'إيجار عدسة سيجما 85mm f/1.4 - البورتريه الاحترافي

عدسة بورتريه احترافية للإيجار. مثالية للتصوير الاحترافي والبورتريه.

الميزات:
بعد بؤري 85mm
فتحة عدسة واسعة f/1.4
جودة بصرية استثنائية
تصميم مقاوم للماء والغبار
خلفية ضبابية جميلة
مناسبة للتصوير الاحترافي',
                'feature_en' => 'Rent Sigma 85mm f/1.4 - Professional Portrait

Professional portrait lens for rent. Perfect for professional photography and portraits.

Features:
85mm focal length
Wide f/1.4 aperture
Exceptional optical quality
Water and dust resistant design
Beautiful bokeh
Suitable for professional photography',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 10,
                'category_id' => 4,
                'title_ar' => 'إيجار عدسة تامرون 70-180mm f/2.8',
                'title_en' => 'Rent Tamron 70-180mm f/2.8 Lens',
                'description_ar' => 'إيجار عدسة تامرون 70-180mm f/2.8 Di III VXD - عدسة زووم تليفوتوغرافية احترافية بفتحة عدسة ثابتة.',
                'description_en' => 'Rent Tamron 70-180mm f/2.8 Di III VXD Lens - Professional telephoto zoom lens with constant aperture.',
                'feature_ar' => 'إيجار عدسة تامرون 70-180mm f/2.8 - الزووم الاحترافي

عدسة زووم تليفوتوغرافية احترافية للإيجار. مثالية للتصوير الرياضي والبرية.

الميزات:
نطاق بؤري 70-180mm
فتحة عدسة ثابتة f/2.8
جودة بصرية استثنائية
تصميم مضغوط وخفيف
مناسبة للتصوير الرياضي والبرية
جودة احترافية',
                'feature_en' => 'Rent Tamron 70-180mm f/2.8 - Professional Zoom

Professional telephoto zoom lens for rent. Perfect for sports and wildlife photography.

Features:
70-180mm focal range
Constant f/2.8 aperture
Exceptional optical quality
Compact and lightweight design
Suitable for sports and wildlife photography
Professional quality',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 6,
                'category_id' => 7,
                'title_ar' => 'إيجار حامل مانفروتو 055',
                'title_en' => 'Rent Manfrotto 055 Tripod',
                'description_ar' => 'إيجار حامل مانفروتو 055 ثلاثي القوائم - حامل احترافي متين ومستقر للتصوير الفوتوغرافي والفيديو الاحترافي.',
                'description_en' => 'Rent Manfrotto 055 Tripod - Professional sturdy and stable tripod for professional photography and videography.',
                'feature_ar' => 'إيجار حامل مانفروتو 055 - الاستقرار الاحترافي

حامل ثلاثي القوائم احترافي للإيجار. يوفر استقراراً مثالياً للكاميرات الثقيلة.

الميزات:
متين ومستقر
ارتفاع قابل للتعديل
رأس كرة احترافية
مقاوم للاهتزازات
قابل للطي
مناسب للكاميرات الثقيلة',
                'feature_en' => 'Rent Manfrotto 055 - Professional Stability

Professional tripod for rent. Provides ideal stability for heavy cameras.

Features:
Sturdy and stable
Adjustable height
Professional ball head
Vibration resistant
Foldable
Suitable for heavy cameras',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 7,
                'category_id' => 8,
                'title_ar' => 'إيجار ميكروفون رود Wireless Go II',
                'title_en' => 'Rent Rode Wireless Go II Microphone',
                'description_ar' => 'إيجار ميكروفون رود Wireless Go II لاسلكي - نظام ميكروفون لاسلكي احترافي للفيديو والمحتوى.',
                'description_en' => 'Rent Rode Wireless Go II Wireless Microphone - Professional wireless microphone system for video and content.',
                'feature_ar' => 'إيجار ميكروفون رود Wireless Go II - الصوت اللاسلكي

نظام ميكروفون لاسلكي احترافي للإيجار. يوفر جودة صوت عالية للفيديو.

الميزات:
نظام لاسلكي احترافي
جودة صوت عالية
نطاق واسع
بطارية قابلة لإعادة الشحن
تصميم مضغوط
سهل الاستخدام',
                'feature_en' => 'Rent Rode Wireless Go II - Wireless Sound

Professional wireless microphone system for rent. Delivers high audio quality for video.

Features:
Professional wireless system
High audio quality
Wide range
Rechargeable battery
Compact design
Easy to use',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 8,
                'category_id' => 5,
                'title_ar' => 'إيجار إضاءة جودوكس AD600 Pro',
                'title_en' => 'Rent Godox AD600 Pro Flash',
                'description_ar' => 'إيجار إضاءة جودوكس AD600 Pro - فلاش احترافي قابل للشحن بقوة 600 وات/ثانية مع تقنية TTL.',
                'description_en' => 'Rent Godox AD600 Pro Flash - Professional rechargeable flash with 600 Ws power and TTL technology.',
                'feature_ar' => 'إيجار إضاءة جودوكس AD600 Pro - الإضاءة القوية

فلاش احترافي قوي للإيجار. يوفر إضاءة احترافية للتصوير الفوتوغرافي.

الميزات:
قوة 600 وات/ثانية
تقنية TTL
بطارية قابلة لإعادة الشحن
وقت إعادة الشحن سريع
تصميم احترافي
إضاءة قوية ومرنة',
                'feature_en' => 'Rent Godox AD600 Pro - Powerful Lighting

Powerful professional flash for rent. Provides professional lighting for photography.

Features:
600 Ws power
TTL technology
Rechargeable battery
Fast recycle time
Professional design
Powerful and flexible lighting',
            ],
            [
                'condition' => 'rent',
                'brand_id' => 11,
                'category_id' => 1,
                'title_ar' => 'إيجار كاميرا DJI Ronin 4D',
                'title_en' => 'Rent DJI Ronin 4D Camera',
                'description_ar' => 'إيجار كاميرا DJI Ronin 4D سينمائية - نظام كاميرا سينمائية متكامل مع تثبيت صورة مدمج وتقنيات متقدمة.',
                'description_en' => 'Rent DJI Ronin 4D Cinema Camera - Integrated cinema camera system with built-in image stabilization and advanced technologies.',
                'feature_ar' => 'إيجار كاميرا DJI Ronin 4D - السينما المتكاملة

نظام كاميرا سينمائية متكامل للإيجار. يجمع بين الكاميرا والتثبيت في نظام واحد.

الميزات:
نظام متكامل
تثبيت صورة مدمج 4 محاور
تسجيل فيديو 4K/6K
شاشة OLED مدمجة
بطارية قابلة لإعادة الشحن
تصميم احترافي',
                'feature_en' => 'Rent DJI Ronin 4D - Integrated Cinema

Integrated cinema camera system for rent. Combines camera and stabilization in one system.

Features:
Integrated system
4-axis built-in image stabilization
4K/6K video recording
Built-in OLED screen
Rechargeable battery
Professional design',
            ],
        ];

        // إنشاء منتجات الإيجار
        foreach ($rentProductsData as $index => $productData) {
            $productNumber = $index + 1;

            // الحصول على department_category_id من جدول DepartmentCategory
            $departmentCategory = DepartmentCategory::where('department_id', 1)
                ->where('category_id', $productData['category_id'])
                ->first();

            $product = Product::create([
                'image'                   => "rent{$productNumber}.jpg",
                "department_id"           => 1,
                'brand_id'                => $productData['brand_id'],
                'category_id'             => $productData['category_id'],
                "department_category_id"  => $departmentCategory ? $departmentCategory->id : null,
                'type'                    => 'standard',
                'condition'               => $productData['condition'],
                'status'                  => 1,
            ]);

            $product->setTranslations([
                'ar' => [
                    'title' => $productData['title_ar'],
                    'description' => $productData['description_ar'],
                ],
                'en' => [
                    'title'       => $productData['title_en'],
                    'description' => $productData['description_en'],
                ],
            ]);

            $skuNumber = str_pad($productNumber, 3, '0', STR_PAD_LEFT);
            $product->variant()->create([
                'sku' => "RENT-{$skuNumber}",
                'attribute_values' => '',
                'price_before_discount' => 3000 + ($productNumber * 50),
                'discount_percentage' => 0,
                'price' => 3000 + ($productNumber * 50),
                'quantity' => 5,
                'status' => 1,
            ]);

            $product->images()->create([
                'image' => "product-1.jpg",
            ]);
            $product->images()->create([
                'image' => "product-2.jpg",
            ]);
            $product->images()->create([
                'image' => "product-3.jpg",
            ]);
            $product->images()->create([
                'image' => "product-4.jpg",
            ]);
            $product->images()->create([
                'image' => "product-5.jpg",
            ]);

            $product_feature = ProductFeature::create([
                'product_id' => $product->id,
            ]);
            $product_feature->setTranslations([
                'ar' => [
                    'title' => 'ميزات المنتج',
                    'description' => $productData['feature_ar'],
                ],
                'en' => [
                    'title'       => 'Product Features',
                    'description' => $productData['feature_en'],
                ],
            ]);
        }





    }
}
