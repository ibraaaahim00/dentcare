<?php

use App\Enums\UserRole;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);
    $this->artisan('db:seed', ['--class' => 'WorkingHourSeeder']);
    $this->artisan('db:seed', ['--class' => 'AppointmentSettingSeeder']);

    $this->patient = User::factory()->create([
        'email' => 'api_patient@example.com',
        'password' => Hash::make('password123'),
        'role' => UserRole::Patient,
    ]);

    $this->doctorUser = User::factory()->create([
        'role' => UserRole::Doctor,
    ]);

    $this->doctor = Doctor::create([
        'user_id' => $this->doctorUser->id,
        'specialization' => 'Endodontics',
        'experience_years' => 11,
        'consultation_fee' => 70.00,
        'is_active' => true,
    ]);

    $this->service = Service::create([
        'name_ar' => 'علاج عصب الأسنان',
        'name_en' => 'Root Canal Treatment',
        'slug' => 'root-canal-api',
        'description_ar' => 'وصف تجريبي',
        'description_en' => 'Test description',
        'duration' => 30,
        'price' => 150.00,
        'is_active' => true,
    ]);

    $this->doctor->services()->attach($this->service->id);
});

test('public client can fetch active services via API with JSON envelope', function () {
    $response = $this->getJson('/api/v1/services');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => ['id', 'name', 'name_ar', 'name_en', 'slug', 'duration', 'price', 'image_url'],
            ],
        ])
        ->assertJson([
            'success' => true,
        ]);
});

test('public client can fetch active doctors and available slots via API', function () {
    $response = $this->getJson('/api/v1/doctors');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    $sundayDate = Carbon::now()->next(Carbon::SUNDAY)->toDateString();
    $slotsResponse = $this->getJson("/api/v1/doctors/{$this->doctor->id}/available-slots?date={$sundayDate}&service_id={$this->service->id}");

    $slotsResponse->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['time', 'end_time', 'available'],
            ],
        ]);
});

test('patient can authenticate via API and receive Sanctum bearer token', function () {
    $response = $this->postJson('/api/v1/auth/login', [
        'email' => 'api_patient@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user' => ['id', 'name', 'email', 'role'],
                'token',
            ],
        ]);

    $token = $response->json('data.token');
    expect($token)->not->toBeEmpty();
});

test('unauthenticated request to api appointments returns 401', function () {
    $response = $this->getJson('/api/v1/appointments');
    $response->assertStatus(401);
});

test('authenticated patient can book appointment via REST API', function () {
    $token = $this->patient->createToken('test-mobile-app')->plainTextToken;
    $targetDate = Carbon::now()->next(Carbon::MONDAY)->toDateString();

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/v1/appointments', [
            'service_id' => $this->service->id,
            'doctor_id' => $this->doctor->id,
            'appointment_date' => $targetDate,
            'start_time' => '11:00',
            'patient_notes' => 'API booked appointment',
        ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'patient_id',
                'doctor_id',
                'service_id',
                'start_time',
                'end_time',
                'status',
            ],
        ]);

    $this->assertDatabaseHas('appointments', [
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'start_time' => '11:00:00',
    ]);
});

test('visitor can submit contact message via REST API', function () {
    $response = $this->postJson('/api/v1/contact', [
        'name' => 'Sara Al-Ghamdi',
        'email' => 'sara@example.com',
        'phone' => '+966501234567',
        'subject' => 'Dental Consultation Query',
        'message' => 'I would like to inquire about teeth whitening options and availability.',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
        ]);

    $this->assertDatabaseHas('contact_messages', [
        'email' => 'sara@example.com',
        'subject' => 'Dental Consultation Query',
    ]);
});
