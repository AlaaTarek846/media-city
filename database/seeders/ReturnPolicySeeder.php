<?php

namespace Database\Seeders;

use App\Models\ReturnPolicy;
use Illuminate\Database\Seeder;

class ReturnPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ReturnPolicy::truncate();

        $area = ReturnPolicy::create([
            'id'   => 1,
        ]);

        $area->setTranslations([
            'ar' => [
                'title'       => 'سياسة الإرجاع',
                'description' => "<h5>سياسة الإرجاع</h5>
              <p>نريدك أن تكون راضيًا تمامًا عن مشترياتك! إذا لم تكن سعيدًا بطلبك، فإننا نقدم
              سياسة إرجاع خالية من المتاعب.</p>

              <h5 class=\"mb-3\">معايير الأهلية للإرجاع:</h5>
              <ul>
                <li>يتم قبول الإرجاع خلال 7 أيام من التسليم.</li>
                <li>يجب أن تكون العناصر غير مستخدمة وغير مغسولة وفي عبواتها الأصلية مع جميع العلامات سليمة.</li>
                <li>لا يتم قبول الإرجاع للسلع النهائية أو السلع المخفضة ما لم تصل تالفة أو معيبة.</li>
              </ul>

              <h5 class=\"mb-3\">كيفية بدء عملية الإرجاع:</h5>
              <ol>
                <li>اتصل بفريق الدعم لدينا على [بريدك الإلكتروني / صفحة الدعم].</li>
                <li>قدم رقم طلبك وسبب الإرجاع.</li>
                <li>سنوجهك خلال عملية شحن الإرجاع.</li>
              </ol>

              <h5 class=\"mb-3\">عملية الاسترداد والتبادل:</h5>
              <ul>
                <li>بمجرد استلامنا وفحصنا العنصر، سنقوم بمعالجة استردادك في غضون 5-7 أيام عمل.</li>
                <li>سيتم إصدار المبالغ المستردة إلى وسيلة الدفع الأصلية.</li>
                <li>إذا كنت تفضل التبادل، فسوف نقوم بشحن العنصر البديل بمجرد الموافقة على الإرجاع.</li>
              </ul>

              <h5 class=\"mb-3\">شحن الإرجاع:</h5>
              <ul>
                <li>يتحمل العملاء تكاليف شحن الإرجاع ما لم يكن العنصر معيبًا أو غير صحيح.</li>
                <li>نوصي باستخدام طريقة شحن قابلة للتتبع لضمان التسليم الآمن.</li>
                <li>لأي مساعدة، لا تتردد في التواصل مع فريق دعم العملاء لدينا.</li>
              </ul>",
            ],
            'en' => [
                'title'       => 'Return Policy',
                'description' => "<h5>Return Policy</h5>
              <p>We want you to be completely satisfied with your purchase! If you're not happy with your order, we offer
                a hassle-free return policy.</p>

              <h5 class=\"mb-3\">Eligibility for Returns:</h5>
              <ul>
                <li>Returns are accepted within 7 days of delivery.</li>
                <li>Items must be unused, unwashed, and in their original packaging with all tags intact.</li>
                <li>Returns are not accepted for final sale or clearance items unless they arrive damaged or defective.</li>
              </ul>

              <h5 class=\"mb-3\">How to Initiate a Return:</h5>
              <ol>
                <li>Contact our support team at [Your Email/Support Page].</li>
                <li>Provide your order number and reason for the return.</li>
                <li>We will guide you through the return shipping process.</li>
              </ol>

              <h5 class=\"mb-3\">Refund & Exchange Process:</h5>
              <ul>
                <li>Once we receive and inspect the item, we will process your refund within 5-7 business days.</li>
                <li>Refunds will be issued to the original payment method.</li>
                <li>If you prefer an exchange, we will ship the replacement item once the return is approved.</li>
              </ul>

              <h5 class=\"mb-3\">Return Shipping:</h5>
              <ul>
                <li>Customers are responsible for return shipping costs unless the item is defective or incorrect.</li>
                <li>We recommend using a trackable shipping method to ensure safe delivery.</li>
                <li>For any assistance, feel free to reach out to our customer support team.</li>
              </ul>",
            ],
        ]);

    }
}
