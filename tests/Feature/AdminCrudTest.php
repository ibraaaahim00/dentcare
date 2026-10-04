<?php

use App\Enums\ReviewStatus;
use App\Enums\UserRole;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);
    $this->artisan('db:seed', ['--class' => 'WorkingHourSeeder']);
    $this->artisan('db:seed', ['--class' => 'AppointmentSettingSeeder']);

    $this->admin = User::factory()->create([
        'role' => UserRole::Admin,
    ]);
});

test('admin can create a new doctor and user profile', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.doctors.store'), [
        'name' => 'Dr. Layla Hani',
        'email' => 'layla@dentcare.com',
        'phone' => '+966509998877',
        'password' => 'SecurePass123!',
        'specialization' => 'Pediatric Dentistry',
        'experience_years' => 9,
        'consultation_fee' => 65.00,
        'bio' => 'Experienced pediatric dental care specialist.',
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.doctors.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'email' => 'layla@dentcare.com',
        'role' => UserRole::Doctor->value,
    ]);

    $this->assertDatabaseHas('doctors', [
        'specialization' => 'Pediatric Dentistry',
        'consultation_fee' => 65.00,
    ]);
});

test('admin can create and update a dental service', function () {
    // 1. Create service
    $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
        'name_ar' => 'حشو الأسنان التجميلي',
        'name_en' => 'Composite Cosmetic Filling',
        'slug' => 'composite-filling',
        'description_ar' => 'حشوات سيراميكية مطابقة للون الأسنان الطبيعي',
        'description_en' => 'Tooth-colored composite restoration',
        'duration' => 30,
        'price' => 120.00,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.services.index'));

    $service = Service::where('slug', 'composite-filling')->first();
    expect($service)->not->toBeNull();

    // 2. Update service
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.services.update', $service->id), [
        'name_ar' => 'حشو الأسنان التجميلي المطور',
        'name_en' => 'Advanced Composite Cosmetic Filling',
        'slug' => 'composite-filling',
        'description_ar' => 'حشوات سيراميكية مطابقة للون الأسنان الطبيعي',
        'description_en' => 'Tooth-colored composite restoration',
        'duration' => 45,
        'price' => 140.00,
        'is_active' => '1',
    ]);

    $updateResponse->assertRedirect(route('admin.services.index'));

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'name_en' => 'Advanced Composite Cosmetic Filling',
        'duration' => 45,
        'price' => 140.00,
    ]);
});

test('admin can moderate review from pending to approved', function () {
    $patient = User::factory()->create(['role' => UserRole::Patient]);

    $review = Review::create([
        'patient_id' => $patient->id,
        'rating' => 5,
        'comment' => 'Brilliant service and spotless hygiene standards!',
        'status' => ReviewStatus::Pending,
    ]);

    $response = $this->actingAs($this->admin)->patch(route('admin.reviews.update-status', $review->id), [
        'status' => 'approved',
    ]);

    $response->assertRedirect(route('admin.reviews.index'));

    $this->assertDatabaseHas('reviews', [
        'id' => $review->id,
        'status' => ReviewStatus::Approved->value,
    ]);
});

test('admin can update appointment booking constraints', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.settings.update-clinic'), [
        'clinic_name_ar' => 'مجمع دينت كير لطب الأسنان',
        'clinic_name_en' => 'DentCare Medical Dental Complex',
        'email' => 'admin@dentcare.com',
        'phone' => '+966114567890',
        'emergency_phone' => '+966501234567',
        'address_ar' => 'الرياض، العليا',
        'address_en' => 'Olaya, Riyadh',
        'booking_interval' => 45,
        'minimum_notice_hours' => 3,
        'maximum_days_ahead' => 45,
        'cancellation_hours' => 24,
    ]);

    $response->assertRedirect(route('admin.settings.index'));

    $this->assertDatabaseHas('appointment_settings', [
        'booking_interval' => 45,
        'minimum_notice_hours' => 3,
        'maximum_days_ahead' => 45,
        'cancellation_hours' => 24,
    ]);
});
