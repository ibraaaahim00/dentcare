<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@dentcare.com'],
            [
                'name' => 'Dr. ebrahime alaa (Admin)',
                'phone' => '+201500052085',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'gender' => Gender::Male,
                'date_of_birth' => '1982-05-15',
                'email_verified_at' => now(),
            ]
        );

        // 2. Doctors
        $doctorsData = [
            [
                'user' => [
                    'name' => 'Dr. Sarah Mansour',
                    'email' => 'doctor1@dentcare.com',
                    'phone' => '+966500000011',
                    'password' => Hash::make('password'),
                    'role' => UserRole::Doctor,
                    'gender' => Gender::Female,
                    'date_of_birth' => '1988-08-20',
                    'email_verified_at' => now(),
                ],
                'doctor' => [
                    'specialization' => 'Orthodontics & Clear Aligners',
                    'bio' => 'Consultant in orthodontic care with extensive international clinical experience across invisible aligners and Damon system corrections.',
                    'qualifications' => 'BDS, MSc Orthodontics (King Saud University), Fellow of World Federation of Orthodontists',
                    'experience_years' => 12,
                    'consultation_fee' => 75.00,
                    'is_active' => true,
                    'sort_order' => 1,
                ],
            ],
            [
                'user' => [
                    'name' => 'Dr. Ahmad Al-Khatib',
                    'email' => 'doctor2@dentcare.com',
                    'phone' => '+966500000012',
                    'password' => Hash::make('password'),
                    'role' => UserRole::Doctor,
                    'gender' => Gender::Male,
                    'date_of_birth' => '1984-03-11',
                    'email_verified_at' => now(),
                ],
                'doctor' => [
                    'specialization' => 'Oral & Maxillofacial Implantology',
                    'bio' => 'Senior dental implantologist specializing in immediate load implants, sinus lift augmentations, and full-mouth rehabilitations.',
                    'qualifications' => 'DDS, PhD Oral & Maxillofacial Surgery, German Board in Implant Dentistry (DGZI)',
                    'experience_years' => 16,
                    'consultation_fee' => 90.00,
                    'is_active' => true,
                    'sort_order' => 2,
                ],
            ],
            [
                'user' => [
                    'name' => 'Dr. Reem Al-Zahrani',
                    'email' => 'doctor3@dentcare.com',
                    'phone' => '+966500000013',
                    'password' => Hash::make('password'),
                    'role' => UserRole::Doctor,
                    'gender' => Gender::Female,
                    'date_of_birth' => '1992-11-04',
                    'email_verified_at' => now(),
                ],
                'doctor' => [
                    'specialization' => 'Cosmetic Dentistry & Endodontics',
                    'bio' => 'Specialist in digital smile design, porcelain veneers, microscopic root canal treatments, and painless laser dentistry.',
                    'qualifications' => 'BDS, Advanced Certificate in Aesthetic Dentistry (NYU), Endodontics Specialist',
                    'experience_years' => 8,
                    'consultation_fee' => 60.00,
                    'is_active' => true,
                    'sort_order' => 3,
                ],
            ],
        ];

        foreach ($doctorsData as $item) {
            $user = User::updateOrCreate(
                ['email' => $item['user']['email']],
                $item['user']
            );

            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                array_merge($item['doctor'], ['user_id' => $user->id])
            );
        }

        // 3. Patients
        $patientsData = [
            [
                'name' => 'Mohammed Al-Otaibi',
                'email' => 'patient1@dentcare.com',
                'phone' => '+966551234567',
                'password' => Hash::make('password'),
                'role' => UserRole::Patient,
                'gender' => Gender::Male,
                'date_of_birth' => '1995-04-12',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Noura Al-Shehri',
                'email' => 'patient2@dentcare.com',
                'phone' => '+966557654321',
                'password' => Hash::make('password'),
                'role' => UserRole::Patient,
                'gender' => Gender::Female,
                'date_of_birth' => '1998-09-25',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Khaled Al-Ghamdi',
                'email' => 'patient3@dentcare.com',
                'phone' => '+966559876543',
                'password' => Hash::make('password'),
                'role' => UserRole::Patient,
                'gender' => Gender::Male,
                'date_of_birth' => '1990-01-30',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($patientsData as $patient) {
            User::updateOrCreate(
                ['email' => $patient['email']],
                $patient
            );
        }
    }
}
