<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Enums\ReviewStatus;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $completed = Appointment::where('status', AppointmentStatus::Completed)->get();

        $reviewsData = [
            [
                'rating' => 5,
                'comment' => 'تجربة استثنائية بكل المقاييس! الدكتور سارة كانت في غاية اللطف والاحترافية، ونتيجة تبييض الأسنان بالليزر فاقت كل توقعاتي بدون أي حساسية.',
                'status' => ReviewStatus::Approved,
            ],
            [
                'rating' => 5,
                'comment' => 'Professional clinic from reception to surgery! Dr. Ahmad placed my dental implant smoothly and painlessly. Best dental care in the region.',
                'status' => ReviewStatus::Approved,
            ],
            [
                'rating' => 4,
                'comment' => 'خدمة ممتازة ودقة في المواعيد بدون انتظار، نظافة العيادة والتعقيم على أعلى المعايير.',
                'status' => ReviewStatus::Approved,
            ],
        ];

        foreach ($completed as $index => $apt) {
            if (isset($reviewsData[$index])) {
                Review::updateOrCreate(
                    [
                        'patient_id' => $apt->patient_id,
                        'appointment_id' => $apt->id,
                    ],
                    array_merge($reviewsData[$index], [
                        'doctor_id' => $apt->doctor_id,
                    ])
                );
            }
        }
    }
}
