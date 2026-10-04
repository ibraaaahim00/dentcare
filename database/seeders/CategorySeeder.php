<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name_ar' => 'صحة الفم والأسنان', 'name_en' => 'Oral Health & Hygiene', 'slug' => 'oral-health'],
            ['name_ar' => 'طب الأسنان التجميلي', 'name_en' => 'Cosmetic Dentistry', 'slug' => 'cosmetic-dentistry'],
            ['name_ar' => 'زراعة وجراحة الفم', 'name_en' => 'Dental Implants & Surgery', 'slug' => 'dental-implants'],
            ['name_ar' => 'تقويم الأسنان', 'name_en' => 'Orthodontics & Aligners', 'slug' => 'orthodontics'],
            ['name_ar' => 'علاج الجذور والعصب', 'name_en' => 'Endodontics', 'slug' => 'endodontics'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
