<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question_ar' => 'هل عملية زراعة الأسنان مؤلمة؟',
                'question_en' => 'Is dental implant surgery painful?',
                'answer_ar' => 'تُجرى زراعة الأسنان تحت التخدير الموضعي المتطور ودون الشعور بأي ألم أثناء الإجراء. بعد انتهاء الجلسة، قد يشعر المريض بانزعاج طفيف جداً يتم السيطرة عليه تماماً بمسكنات خفيفة.',
                'answer_en' => 'Dental implant placement is performed under advanced localized anesthesia and is completely painless. Post-operative discomfort is typically minimal and easily managed with prescribed mild analgesics.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question_ar' => 'كم تدوم نتيجة تبييض الأسنان بالليزر زووم؟',
                'question_en' => 'How long do Zoom laser whitening results last?',
                'answer_ar' => 'تدوم نتائج التبييض عادة من سنة إلى ثلاث سنوات، اعتماداً على العادات اليومية للمريض مثل التدخين وشرب القهوة والالتزام بتعليمات النظافة الفموية.',
                'answer_en' => 'Results typically last from 1 to 3 years, heavily contingent upon oral hygiene diligence and lifestyle habits such as coffee intake and smoking.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question_ar' => 'هل التقويم الشفاف مناسب لجميع الحالات والأعمار؟',
                'question_en' => 'Are clear aligners suitable for all orthodontic conditions and ages?',
                'answer_ar' => 'التقويم الشفاف مناسب للأغلبية العظمى من حالات التزاحم، الفراغات، والعضة المعكوسة للمراهقين والبالغين. يقوم استشاري التقويم بتقييم الخطة ثلاثية الأبعاد بدقة قبل البدء.',
                'answer_en' => 'Clear aligners effectively address overcrowding, spacing, and crossbites for both adolescents and adults. Our specialist determines eligibility via a comprehensive 3D scan.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question_ar' => 'كيف يمكنني حجز أو تعديل موعدي عبر الموقع؟',
                'question_en' => 'How can I book or reschedule my appointment online?',
                'answer_ar' => 'يمكنك اختيار الخدمة والطبيب والوقت المناسب بنقرات سريعة وتأكيد الحجز فورياً. كما يمكنك إدارة مواعيدك وإلغائها قبل 12 ساعة من لوحة تحكم المريض الخاصة بك.',
                'answer_en' => 'You can select your desired dental service, specialist, and live time slot through our instant booking engine. You can also review or cancel appointments up to 12 hours in advance via your patient dashboard.',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question_en' => $faq['question_en']],
                $faq
            );
        }
    }
}
