<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductFeature;
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

        $product = Product::create([
            'image'   => 'product-08.png',
            'brand_id' => 1,
            'category_id' => 5,
            'type' => 'standard',
            'status' => 1,
        ]);

        $product->setTranslations([
            'ar' => [
                'title' => 'فستان كلاسيكي',
                'description' => 'فستان كلاسيكي لا يخرج عن الموضة، مثالي لأي مناسبة.',
            ],
            'en' => [
                'title'       => 'classic dress',
                'description' => 'A classic dress that never goes out of style, perfect for any occasion.',
            ],

        ]);

        $product->variants()->create([
                'sku' => 'SKU-001',
                'attribute_values' => '',
                'price_before_discount' => 5000,
                'discount_percentage' => 10,
                'price' => 4500,
                'quantity' => 300,
                'status' =>     1,
            ]);

            $product->images()->create([
                    'image' => '01-01.png',
                ]);
            $product->images()->create([
                    'image' => '01-02.png',
                ]);
            $product->images()->create([
                    'image' => '01-03.png',
                ]);
            $product->images()->create([
                    'image' => '01-04.png',
                ]);
            $product->images()->create([
                    'image' => '01-05.png',
                ]);

        $product_feature = ProductFeature::create([
            'product_id' => $product->id,
        ]);
        $product_feature->setTranslations([
            'ar' => [
                'title' => 'ميزات المنتج',
                'description' => "تيشيرت سادة بياقة دائرية - راحة وأناقة كلاسيكية

جدد خزانة ملابسك مع تيشيرت سادة بياقة دائرية، قطعة أساسية لا غنى عنها للارتداء اليومي. صُمم هذا التيشيرت ليوفر لك الراحة والتنوع، وهو مصنوع من قماش عالي الجودة، مما يضمن لك ملمسًا ناعمًا وجيد التهوية على بشرتك. سواء كنت ترتديه لنزهة غير رسمية أو ترتديه تحت سترة لإطلالة أنيقة، فهذا التيشيرت هو الخيار الأمثل.

بتصميمه البسيط وياقته الدائرية الكلاسيكية، يُضفي هذا التيشيرت لمسة عصرية تناسب جميع المناسبات. خياطته عالية الجودة تضمن المتانة، مما يجعله مثاليًا للاستخدام اليومي. يُمكن تنسيقه بسهولة مع الجينز أو السراويل الرياضية أو السراويل القصيرة، ليمنحك إطلالة مريحة وعصرية في آن واحد. يتميز القماش بقدرته على امتصاص الرطوبة، مما يُبقيك منتعشًا ومريحًا طوال اليوم.

يتوفر هذا التيشيرت بألوان ومقاسات متعددة، وهو قطعة أساسية في خزانة ملابس الرجال والنساء على حد سواء. سواءً كنتَ تذهب إلى صالة الألعاب الرياضية، أو لقضاء وقتٍ ممتع، أو حتى للاسترخاء في المنزل، فإن هذا التيشيرت يجمع بين الأناقة والعملية.

الميزات:
مزيج من القطن والبوليستر الفاخر لراحة فائقة
قماش خفيف الوزن ومسامي
تصميم كلاسيكي بياقة دائرية لإطلالة عصرية
خياطة متينة تدوم طويلًا
متوفر بألوان ومقاسات متعددة
سهل الغسل والصيانة",
            ],
            'en' => [
                'title'       => 'Product Features',
                'description' => "Solid Round Neck T-shirt – Classic Comfort & Style
Upgrade your wardrobe with our Solid Round Neck T-shirt, a must-have staple for everyday wear. Designed for both comfort and versatility, this t-shirt is crafted from premium-quality fabric, ensuring a soft and breathable feel against your skin. Whether you're dressing up for a casual outing or layering it under a jacket for a stylish look, this t-shirt is the perfect choice.

With its minimalist design and classic round neckline, this t-shirt offers a timeless appeal that suits all occasions. The high-quality stitching provides durability, making it ideal for daily use. It pairs effortlessly with jeans, joggers, or shorts, giving you a relaxed yet trendy look. The fabric is moisture-wicking, keeping you cool and comfortable throughout the day.

Available in multiple colors and sizes, the Solid Round Neck T-shirt is a wardrobe essential for men and women alike. Whether you're hitting the gym, going for a casual hangout, or just lounging at home, this t-shirt delivers both style and functionality.

Features:
Premium cotton/polyester blend for comfort
Breathable and lightweight fabric
Classic round neck design for a timeless look
Durable stitching for long-lasting wear
Available in multiple colors and sizes
Easy to wash and maintain",
            ],
        ]);


          $product = Product::create([
            'image'   => 'product-01.png',
            'brand_id' => 3,
            'category_id' => 2,
            'type' => 'variant',
            'status' => 1,
        ]);

        $product->setTranslations([
            'ar' => [
                'title' => 'بالطو شتوى كتان',
                'description' => 'بالطو شتوى كتان أنيق، مثالي لفصل الشتاء.',
            ],
            'en' => [
                'title'       => 'Winter linen coat',
                'description' => 'A stylish linen coat for winter, perfect for keeping warm.',
            ],

        ]);

        $product->variants()->create([
                'sku' => 'SKU-003',
                'attribute_values' => 'Blue,L',
                'price_before_discount' => 3000,
                'discount_percentage' => 5,
                'price' => 2850,
                'quantity' => 100,
                'status' =>     1,
            ]);
        $product->variants()->create([
                'sku' => 'SKU-004',
                'attribute_values' => 'Blue,M',
                'price_before_discount' => 2800,
                'discount_percentage' => 5,
                'price' => 2660,
                'quantity' => 100,
                'status' =>     1,
            ]);
        $product->variants()->create([
                'sku' => 'SKU-005',
                'attribute_values' => 'Blue,S',
                'price_before_discount' => 2500,
                'discount_percentage' => 5,
                'price' => 2375,
                'quantity' => 100,
                'status' =>     1,
            ]);

            $product->variants()->create([
                'sku' => 'SKU-006',
                'attribute_values' => 'Read,L',
                'price_before_discount' => 3000,
                'discount_percentage' => 5,
                'price' => 2850,
                'quantity' => 100,
                'status' =>     1,
            ]);
        $product->variants()->create([
                'sku' => 'SKU-007',
                'attribute_values' => 'Read,M',
                'price_before_discount' => 2800,
                'discount_percentage' => 5,
                'price' => 2660,
                'quantity' => 100,
                'status' =>     1,
            ]);
        $product->variants()->create([
                'sku' => 'SKU-008',
                'attribute_values' => 'Read,S',
                'price_before_discount' => 2500,
                'discount_percentage' => 5,
                'price' => 2375,
                'quantity' => 100,
                'status' =>     1,
            ]);

            ProductAttributeValue::create([
                    'product_id' => $product->id,
                    'attribute_id' => 1,
                    'options' => 'L , M , S',
                ]);
        ProductAttributeValue::create([
                    'product_id' => $product->id,
                    'attribute_id' => 2,
                    'options' => 'Blue , Read',
                ]);

                $product->images()->create([
                    'image' => '02-01.png',
                ]);
            $product->images()->create([
                    'image' => '02-02.png',
                ]);
            $product->images()->create([
                    'image' => '02-03.png',
                ]);
            $product->images()->create([
                    'image' => '02-04.png',
                ]);
            $product->images()->create([
                    'image' => '02-05.png',
                ]);

        $product_feature = ProductFeature::create([
            'product_id' => $product->id,
        ]);
        $product_feature->setTranslations([
            'ar' => [
                'title' => 'ميزات المنتج',
                'description' => "تيشيرت سادة بياقة دائرية - راحة وأناقة كلاسيكية

جدد خزانة ملابسك مع تيشيرت سادة بياقة دائرية، قطعة أساسية لا غنى عنها للارتداء اليومي. صُمم هذا التيشيرت ليوفر لك الراحة والتنوع، وهو مصنوع من قماش عالي الجودة، مما يضمن لك ملمسًا ناعمًا وجيد التهوية على بشرتك. سواء كنت ترتديه لنزهة غير رسمية أو ترتديه تحت سترة لإطلالة أنيقة، فهذا التيشيرت هو الخيار الأمثل.

بتصميمه البسيط وياقته الدائرية الكلاسيكية، يُضفي هذا التيشيرت لمسة عصرية تناسب جميع المناسبات. خياطته عالية الجودة تضمن المتانة، مما يجعله مثاليًا للاستخدام اليومي. يُمكن تنسيقه بسهولة مع الجينز أو السراويل الرياضية أو السراويل القصيرة، ليمنحك إطلالة مريحة وعصرية في آن واحد. يتميز القماش بقدرته على امتصاص الرطوبة، مما يُبقيك منتعشًا ومريحًا طوال اليوم.

يتوفر هذا التيشيرت بألوان ومقاسات متعددة، وهو قطعة أساسية في خزانة ملابس الرجال والنساء على حد سواء. سواءً كنتَ تذهب إلى صالة الألعاب الرياضية، أو لقضاء وقتٍ ممتع، أو حتى للاسترخاء في المنزل، فإن هذا التيشيرت يجمع بين الأناقة والعملية.

الميزات:
مزيج من القطن والبوليستر الفاخر لراحة فائقة
قماش خفيف الوزن ومسامي
تصميم كلاسيكي بياقة دائرية لإطلالة عصرية
خياطة متينة تدوم طويلًا
متوفر بألوان ومقاسات متعددة
سهل الغسل والصيانة",
            ],
            'en' => [
                'title'       => 'Product Features',
                'description' => "Solid Round Neck T-shirt – Classic Comfort & Style
Upgrade your wardrobe with our Solid Round Neck T-shirt, a must-have staple for everyday wear. Designed for both comfort and versatility, this t-shirt is crafted from premium-quality fabric, ensuring a soft and breathable feel against your skin. Whether you're dressing up for a casual outing or layering it under a jacket for a stylish look, this t-shirt is the perfect choice.

With its minimalist design and classic round neckline, this t-shirt offers a timeless appeal that suits all occasions. The high-quality stitching provides durability, making it ideal for daily use. It pairs effortlessly with jeans, joggers, or shorts, giving you a relaxed yet trendy look. The fabric is moisture-wicking, keeping you cool and comfortable throughout the day.

Available in multiple colors and sizes, the Solid Round Neck T-shirt is a wardrobe essential for men and women alike. Whether you're hitting the gym, going for a casual hangout, or just lounging at home, this t-shirt delivers both style and functionality.

Features:
Premium cotton/polyester blend for comfort
Breathable and lightweight fabric
Classic round neck design for a timeless look
Durable stitching for long-lasting wear
Available in multiple colors and sizes
Easy to wash and maintain",
            ],
        ]);

    }
}
