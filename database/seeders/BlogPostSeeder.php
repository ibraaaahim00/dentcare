<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('role', 'admin')->first() ?? User::first();
        $categories = Category::all();

        $posts = [
            [
                'title_ar' => 'دليلك الشامل لزراعة الأسنان الفورية: المميزات ونسب النجاح',
                'title_en' => 'Comprehensive Guide to Immediate Dental Implants: Benefits & Success Rates',
                'slug' => 'guide-to-immediate-dental-implants',
                'excerpt_ar' => 'تعرف على تقنية زراعة الأسنان الفورية وكيف تتيح لك استعادة سن مفقود في يوم واحد فقط دون الحاجة للانتظار شهوراً طويلة.',
                'excerpt_en' => 'Discover how modern immediate load implants restore your missing tooth in a single day with optimal aesthetic integration.',
                'content_ar' => "تعتبر زراعة الأسنان الفورية من أبرز التطورات في طب وجراحة الفم الحديث. بفضل التقنيات الرقمية المتقدمة مثل التصوير المقطعي ثلاثي الأبعاد، أصبح بالإمكان وضع الغرسة والسن المؤقت في نفس جلسة خلع السن المتضرر.\n\nمن أهم مميزات هذا الإجراء:\n1. الحفاظ على العظم السنخي ومحيط اللثة الطبيعي.\n2. تقليص عدد الزيارات الجراحية إلى جلسة واحدة.\n3. نتائج جمالية فورية تعيد ثقة المريض بنفسه من اليوم الأول.\n\nينصح دائماً بإجراء تقييم شامل لكثافة العظم والحالة الصحية العامة لضمان أعلى نسبة نجاح للغرسة السويسرية.",
                'content_en' => "Immediate dental implantation represents a paramount breakthrough in modern surgical dentistry. Utilizing advanced 3D CBCT intraoral imaging, the specialist places the implant fixture and a temporary crown immediately following extraction.\n\nKey advantages include:\n1. Preserving alveolar bone architecture and natural gum contour.\n2. Reducing surgical visits and total healing timeframe.\n3. Immediate aesthetic restoration empowering patient confidence.\n\nConsult our implantology consultants to evaluate your bone density and candidacy.",
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'cat_slug' => 'dental-implants',
            ],
            [
                'title_ar' => 'التقويم الشفاف أم التقويم المعدني: أيهما الأنسب لحالتك؟',
                'title_en' => 'Clear Aligners vs Traditional Braces: Which is Right for You?',
                'slug' => 'clear-aligners-vs-traditional-braces',
                'excerpt_ar' => 'مقارنة دقيقة وشاملة بين قوالب التقويم الشفاف Invisalign والتقويم المعدني من حيث الفعالية والراحة والمظهر الجمالي.',
                'excerpt_en' => 'A detailed clinical comparison between Invisalign clear aligners and conventional metallic braces in terms of comfort, duration, and aesthetics.',
                'content_ar' => "عند التفكير في تصحيح اصطفاف الأسنان، يتردد الكثير بين خياري التقويم الشفاف والتقويم المعدني.\n\nالتقويم الشفاف يمتاز بالراحة التامة، إمكانية نزعه أثناء تناول الطعام وتنظيف الأسنان، وعدم لفت الأنظار، مما يجعله الخيار المفضل للمهنيين والبالغين.\n\nبينما يظل التقويم المعدني خياراً ممتازاً للحالات المعقدة وبتكلفة اقتصادية ملائمة. يحدد استشاري التقويم الأنسب بعد عمل المسح الرقمي للفكين.",
                'content_en' => "When embarking on orthodontic realignment, patients frequently weigh transparent aligners against traditional metallic brackets.\n\nClear aligners deliver exceptional comfort, can be removed during meals and oral hygiene regimens, and are virtually invisible—making them ideal for professionals.\n\nMetallic braces remain highly effective for severe bite discrepancies at economical pricing. A personalized 3D digital scan helps determine your optimal pathway.",
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'cat_slug' => 'orthodontics',
            ],
            [
                'title_ar' => 'أسرار الحفاظ على بياض الأسنان بعد جلسة التبييض الاحترافي',
                'title_en' => 'Pro Tips to Maintain Pearly White Teeth After Laser Whitening',
                'slug' => 'maintain-teeth-whitening-results',
                'excerpt_ar' => 'نصائح طبية ذهبية للمحافظة على نتائج تبييض الأسنان بالليزر لأطول فترة ممكنة وتجنب التصبغات السريعة.',
                'excerpt_en' => 'Clinical recommendations to sustain your in-office laser whitening results for years and prevent chromatic stain relapse.',
                'content_ar' => "بعد الخضوع لجلسة تبييض الأسنان بجهاز زووم 4، تصبح مسام المينا أكثر حساسية لامتصاص الصبغات خلال أول 48 ساعة المعروفة بـ (حمية البياض).\n\nأهم النصائح للحفاظ على الابتسامة:\n- تجنب القهوة، الشاي، والمشروبات الغازية الملونة لمدة يومين على الأقل.\n- الامتناع التام عن التدخين.\n- استخدام معجون أسنان مخصص للأسنان الحساسة وتدعيم المينا.\n- شرب الماء بكثرة والمضمضة فوراً بعد تناول الأطعمة الملونة.",
                'content_en' => "Following Zoom 4 laser whitening, dental enamel is temporarily more permeable to extrinsic chromogens during the critical 48-hour 'white diet' phase.\n\nTop practices to preserve your radiance:\n- Abstain from dark coffee, teas, red wine, and colored sodas for at least 48 hours.\n- Cease smoking and tobacco products.\n- Use dentist-approved remineralizing toothpaste.\n- Rinse promptly with water after consuming pigmented food.",
                'is_published' => true,
                'published_at' => now()->subDays(20),
                'cat_slug' => 'cosmetic-dentistry',
            ],
        ];

        foreach ($posts as $postData) {
            $catSlug = $postData['cat_slug'];
            unset($postData['cat_slug']);

            $post = BlogPost::updateOrCreate(
                ['slug' => $postData['slug']],
                array_merge($postData, ['author_id' => $author->id])
            );

            $cat = $categories->firstWhere('slug', $catSlug);
            if ($cat) {
                $post->categories()->syncWithoutDetaching([$cat->id]);
            }
        }
    }
}
