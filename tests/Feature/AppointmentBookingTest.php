<?php

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);
    $this->artisan('db:seed', ['--class' => 'WorkingHourSeeder']);
    $this->artisan('db:seed', ['--class' => 'AppointmentSettingSeeder']);

    $this->patient = User::factory()->create([
        'role' => UserRole::Patient,
    ]);

    $this->doctorUser = User::factory()->create([
        'role' => UserRole::Doctor,
    ]);

    $this->doctor = Doctor::create([
        'user_id' => $this->doctorUser->id,
        'specialization' => 'Orthodontics',
        'experience_years' => 10,
        'consultation_fee' => 75.00,
        'is_active' => true,
    ]);

    $this->service = Service::create([
        'name_ar' => 'فحص واستشارة تقويم الأسنان',
        'name_en' => 'Orthodontic Consultation',
        'slug' => 'ortho-consultation',
        'description_ar' => 'فحص شامل للفكين والأسنان',
        'description_en' => 'Full dental evaluation',
        'duration' => 30,
        'price' => 75.00,
        'is_active' => true,
    ]);

    $this->doctor->services()->attach($this->service->id);
});

test('guest can view booking page with active services and doctors', function () {
    $response = $this->get(route('appointments.create'));

    $response->assertStatus(200)
        ->assertSee('Orthodontic Consultation')
        ->assertSee($this->doctorUser->name);
});

test('patient can successfully book an available appointment slot', function () {
    // Next Sunday (guaranteed open day)
    $targetDate = Carbon::now()->next(Carbon::SUNDAY)->toDateString();

    $response = $this->actingAs($this->patient)->post(route('appointments.store'), [
        'service_id' => $this->service->id,
        'doctor_id' => $this->doctor->id,
        'appointment_date' => $targetDate,
        'start_time' => '10:00',
        'patient_notes' => 'Looking forward to consultation',
    ]);

    $appointment = Appointment::where('patient_id', $this->patient->id)->first();
    expect($appointment)->not->toBeNull();

    $response->assertRedirect(route('patient.appointments.show', $appointment->id))
        ->assertSessionHas('success');

    expect($appointment->appointment_date->format('Y-m-d'))->toBe($targetDate);

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'doctor_id' => $this->doctor->id,
        'service_id' => $this->service->id,
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
        'status' => AppointmentStatus::Pending->value,
    ]);
});

test('double booking the same doctor for overlapping slot is prevented by backend validation', function () {
    $targetDate = Carbon::now()->next(Carbon::MONDAY)->toDateString();

    // First booking
    Appointment::create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'service_id' => $this->service->id,
        'appointment_date' => $targetDate,
        'start_time' => '11:00:00',
        'end_time' => '11:30:00',
        'status' => AppointmentStatus::Confirmed,
    ]);

    // Second patient attempts to book the exact same slot
    $secondPatient = User::factory()->create(['role' => UserRole::Patient]);

    $response = $this->actingAs($secondPatient)->post(route('appointments.store'), [
        'service_id' => $this->service->id,
        'doctor_id' => $this->doctor->id,
        'appointment_date' => $targetDate,
        'start_time' => '11:00',
    ]);

    $response->assertInvalid(['start_time']);

    $this->assertDatabaseCount('appointments', 1);
});

test('booking on a closed clinic day (Friday) is strictly rejected', function () {
    $targetFriday = Carbon::now()->next(Carbon::FRIDAY)->toDateString();

    $response = $this->actingAs($this->patient)->post(route('appointments.store'), [
        'service_id' => $this->service->id,
        'doctor_id' => $this->doctor->id,
        'appointment_date' => $targetFriday,
        'start_time' => '10:00',
    ]);

    $response->assertInvalid(['appointment_date']);
});

test('patient can cancel appointment when outside cancellation cutoff window', function () {
    $futureDate = Carbon::now()->addDays(5)->toDateString();

    $appointment = Appointment::create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'service_id' => $this->service->id,
        'appointment_date' => $futureDate,
        'start_time' => '14:00:00',
        'end_time' => '14:30:00',
        'status' => AppointmentStatus::Pending,
    ]);

    $response = $this->actingAs($this->patient)->post(route('patient.appointments.cancel', $appointment->id), [
        'cancellation_reason' => 'Schedule conflict',
    ]);

    $response->assertRedirect()->assertSessionHas('success');

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'status' => AppointmentStatus::Cancelled->value,
        'cancellation_reason' => 'Schedule conflict',
    ]);
});
