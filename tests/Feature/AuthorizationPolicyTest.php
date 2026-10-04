<?php

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Service;
use App\Models\User;

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);

    $this->patient1 = User::factory()->create(['role' => UserRole::Patient]);
    $this->patient2 = User::factory()->create(['role' => UserRole::Patient]);

    $this->doctorUser1 = User::factory()->create(['role' => UserRole::Doctor]);
    $this->doctor1 = Doctor::create([
        'user_id' => $this->doctorUser1->id,
        'specialization' => 'Orthodontics',
        'experience_years' => 8,
        'consultation_fee' => 50,
        'is_active' => true,
    ]);

    $this->doctorUser2 = User::factory()->create(['role' => UserRole::Doctor]);
    $this->doctor2 = Doctor::create([
        'user_id' => $this->doctorUser2->id,
        'specialization' => 'Cosmetic Dentistry',
        'experience_years' => 6,
        'consultation_fee' => 60,
        'is_active' => true,
    ]);

    $this->service = Service::create([
        'name_ar' => 'خدمة عامة',
        'name_en' => 'General Service',
        'slug' => 'general-service',
        'description_ar' => 'وصف',
        'description_en' => 'Desc',
        'duration' => 30,
        'price' => 50,
        'is_active' => true,
    ]);

    $this->appointment1 = Appointment::create([
        'patient_id' => $this->patient1->id,
        'doctor_id' => $this->doctor1->id,
        'service_id' => $this->service->id,
        'appointment_date' => now()->addDays(2)->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
        'status' => AppointmentStatus::Confirmed,
    ]);

    $this->record1 = MedicalRecord::create([
        'patient_id' => $this->patient1->id,
        'doctor_id' => $this->doctor1->id,
        'appointment_id' => $this->appointment1->id,
        'diagnosis' => 'Caries detected',
        'treatment' => 'Restoration',
        'treatment_date' => now()->subDay()->toDateString(),
    ]);
});

test('patient cannot access another patients appointment details', function () {
    $response = $this->actingAs($this->patient2)
        ->get(route('patient.appointments.show', $this->appointment1->id));

    $response->assertStatus(403);
});

test('patient can access their own appointment details', function () {
    $response = $this->actingAs($this->patient1)
        ->get(route('patient.appointments.show', $this->appointment1->id));

    $response->assertStatus(200);
});

test('patient cannot access another patients medical record', function () {
    $response = $this->actingAs($this->patient2)
        ->get(route('patient.medical-records.show', $this->record1->id));

    $response->assertStatus(403);
});

test('doctor cannot view appointment details of another doctor', function () {
    $response = $this->actingAs($this->doctorUser2)
        ->get(route('doctor.appointments.show', $this->appointment1->id));

    $response->assertStatus(403);
});

test('assigned doctor can view their own appointment details', function () {
    $response = $this->actingAs($this->doctorUser1)
        ->get(route('doctor.appointments.show', $this->appointment1->id));

    $response->assertStatus(200);
});
