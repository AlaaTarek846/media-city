<?php

namespace Database\Seeders;

use App\Models\ShippingInformation;
use Illuminate\Database\Seeder;

class ShippingInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ShippingInformation::truncate();

        $area = ShippingInformation::create([
            'id'   => 1,
        ]);

        $area->setTranslations([
            'ar' => [
                'title'       => 'معلومات الشحن',
                'description' => "<h5 class=\"mb-3\">معلومات الشحن:</h5>
                <ul>
                  <li><b>وقت المعالجة:</b> يتم معالجة الطلبات في غضون 1-2 أيام عمل.</li>
                  <li><b>وقت التسليم:</b> يستغرق الشحن القياسي 5-7 أيام عمل، بينما يستغرق الشحن السريع 2-3 أيام عمل.</li>
                  <li><b>رسوم الشحن:</b> يتم حساب تكاليف الشحن عند الخروج بناءً على موقعك وطريقة الشحن المحددة.</li>
                  <li><b>التتبع:</b> بمجرد شحن طلبك، ستتلقى رقم تتبع عبر البريد الإلكتروني.</li>
                </ul>
                <h5 class=\"mb-3\">سياسة الإرجاع والاستبدال:</h5>
                <ul class=\"mb-0\">
                  <li><b>الأهلية:</b> يتم قبول الإرجاع والاستبدال في غضون 7 أيام من التسليم. يجب أن تكون السلعة غير مرتدية وغير مغسولة وفي عبوتها الأصلية مع وجود العلامات intact.</li>
                  <li><b>عملية الاسترداد:</b> بمجرد استلامنا وفحصنا للسلعة المعادة، سيتم معالجة المبالغ المستردة في غضون 5-7 أيام عمل. سيتم إصدار المبالغ المستردة إلى طريقة الدفع الأصلية.</li>
                  <li><b>التبادل:</b> إذا تلقيت منتجًا معيبًا أو غير صحيح، سنقوم باستبداله دون أي تكلفة إضافية.</li>
                  <li><b>شحن الإرجاع:</b> يتحمل العملاء تكاليف شحن الإرجاع ما لم تكن السلعة معيبة أو غير صحيحة.</li>
                </ul>",
            ],
            'en' => [
                'title'       => 'Shipping Information',
                'description' => "<h5 class=\"mb-3\">Shipping Information:</h5>
                <ul>
                  <li><b>Processing Time:</b>Orders are processed within 1-2 business days.</li>
                  <li><b>Delivery Time:</b>Standard shipping takes 5-7 business days, while express shipping takes 2-3 business days.</li>
                  <li><b>Shipping Charges:</b>Shipping costs are calculated at checkout based on your location and selected shipping method.</li>
                  <li><b>Tracking:</b>Once your order is shipped, you will receive a tracking number via email.</li>
                </ul>
                <h5 class=\"mb-3\">Return & Exchange Policy:</h5>
                <ul class=\"mb-0\">
                  <li><b>Eligibility:</b>Returns and exchanges are accepted within 7 days of delivery. The item must be unworn, unwashed, and in its original packaging with tags intact..</li>
                  <li><b>Refund Process:</b>Once we receive and inspect the returned item, refunds will be processed within 5-7 business days. Refunds will be issued to the original payment method.</li>
                  <li><b>Exchange:</b>If you received a defective or incorrect product, we will replace it at no extra cost.</li>
                  <li><b>Return Shipping:</b>Customers are responsible for return shipping costs unless the item is defective or incorrect.</li>
                </ul>",
            ],
        ]);

    }
}
