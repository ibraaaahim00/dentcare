<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            [
                'title_ar' => 'مريض يثق بخدماتنا',
                'title_en' => 'Happy Patients',
                'value' => '5,000+',
                'icon' => 'users',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title_ar' => 'أطباء واستشاريون',
                'title_en' => 'Specialist Doctors',
                'value' => '12+',
                'icon' => 'user-check',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title_ar' => 'خدمة تخصصية متطورة',
                'title_en' => 'Dental Procedures',
                'value' => '25+',
                'icon' => 'sparkles',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title_ar' => 'نسبة رضا المرضى',
                'title_en' => 'Satisfaction Rate',
                'value' => '99.4%',
                'icon' => 'star',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            Statistic::create($stat);
        }
    }
}
