<?php

namespace Database\Seeders;

use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Faisal Al-Dosari',
                'email' => 'faisal@example.com',
                'phone' => '+966501112233',
                'subject' => 'استفسار عن خطط تقسيط زراعة الأسنان',
                'message' => 'السلام عليكم، أود الاستفسار عما إذا كانت العيادة توفر خطط تقسيط ميسرة أو تتعامل مع شركات التأمين الطبي لعمليات زراعة الأسنان والتعويضات الثابتة. شكراً لكم.',
                'status' => ContactMessageStatus::Unread,
            ],
            [
                'name' => 'Laila Mansoor',
                'email' => 'laila.m@example.com',
                'phone' => '+966504445566',
                'subject' => 'Booking inquiry for international patient',
                'message' => 'Hello, I will be visiting Riyadh next month for two weeks. Is it possible to arrange a preliminary consultation and complete laser teeth whitening and veneer checkup during this timeframe? Thank you.',
                'status' => ContactMessageStatus::Read,
                'read_at' => now()->subDay(),
            ],
        ];

        foreach ($messages as $msg) {
            ContactMessage::updateOrCreate(
                ['email' => $msg['email'], 'subject' => $msg['subject']],
                $msg
            );
        }
    }
}
