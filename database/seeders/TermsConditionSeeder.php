<?php

namespace Database\Seeders;

use App\Models\TermsCondition;
use Illuminate\Database\Seeder;

class TermsConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TermsCondition::truncate();

        $termsCondition = TermsCondition::create([
            'id'   => 1,
        ]);

        $termsCondition->setTranslations([
            'ar' => [
                'title'       => 'الشروط والأحكام',
                'description' => "<h5>الشروط والأحكام</h5>
              <p>مرحبًا بك في موقعنا. من خلال الوصول إلى هذا الموقع واستخدامه، فإنك توافق على الالتزام بالشروط والأحكام التالية.</p>

              <h5 class=\"mb-3\">قبول الشروط:</h5>
              <ul>
                <li>باستخدام هذا الموقع، فإنك تقر بأنك قد قرأت وفهمت ووافقت على الالتزام بهذه الشروط والأحكام.</li>
                <li>إذا كنت لا توافق على أي من هذه الشروط، يرجى عدم استخدام هذا الموقع.</li>
                <li>نحتفظ بالحق في تعديل هذه الشروط في أي وقت دون إشعار مسبق.</li>
              </ul>

              <h5 class=\"mb-3\">استخدام الموقع:</h5>
              <ul>
                <li>يجب استخدام الموقع للأغراض القانونية فقط.</li>
                <li>يُمنع استخدام الموقع بأي طريقة قد تضر أو تعطل أو تفرط في تحميل الموقع.</li>
                <li>يُمنع محاولة الوصول غير المصرح به إلى أي جزء من الموقع.</li>
              </ul>

              <h5 class=\"mb-3\">الملكية الفكرية:</h5>
              <ul>
                <li>جميع المحتويات الموجودة على هذا الموقع، بما في ذلك النصوص والصور والتصاميم، محمية بحقوق الطبع والنشر.</li>
                <li>لا يجوز نسخ أو توزيع أو تعديل أي محتوى دون الحصول على إذن كتابي منا.</li>
              </ul>

              <h5 class=\"mb-3\">الخصوصية:</h5>
              <ul>
                <li>نحترم خصوصيتك ونلتزم بحماية معلوماتك الشخصية وفقًا لسياسة الخصوصية الخاصة بنا.</li>
                <li>نستخدم المعلومات التي تقدمها لنا فقط للأغراض المذكورة في سياسة الخصوصية.</li>
              </ul>",
            ],
            'en' => [
                'title'       => 'Terms & Conditions',
                'description' => "<h5>Terms & Conditions</h5>
              <p>Welcome to our website. By accessing and using this site, you agree to comply with the following terms and conditions.</p>

              <h5 class=\"mb-3\">Acceptance of Terms:</h5>
              <ul>
                <li>By using this website, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.</li>
                <li>If you do not agree to any of these terms, please do not use this website.</li>
                <li>We reserve the right to modify these terms at any time without prior notice.</li>
              </ul>

              <h5 class=\"mb-3\">Use of Website:</h5>
              <ul>
                <li>The website must be used for lawful purposes only.</li>
                <li>You may not use the website in any way that could damage, disable, or overload the website.</li>
                <li>You may not attempt to gain unauthorized access to any part of the website.</li>
              </ul>

              <h5 class=\"mb-3\">Intellectual Property:</h5>
              <ul>
                <li>All content on this website, including text, images, and designs, is protected by copyright.</li>
                <li>You may not copy, distribute, or modify any content without our written permission.</li>
              </ul>

              <h5 class=\"mb-3\">Privacy:</h5>
              <ul>
                <li>We respect your privacy and are committed to protecting your personal information in accordance with our privacy policy.</li>
                <li>We use the information you provide to us only for the purposes stated in our privacy policy.</li>
              </ul>",
            ],
        ]);

    }
}

