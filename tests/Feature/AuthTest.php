<?php

use App\Enums\UserRole;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);
});

test('patient can view login and registration pages', function () {
    $this->get(route('login'))->assertStatus(200);
    $this->get(route('register'))->assertStatus(200);
});

test('patient can register a new account and access dashboard', function () {
    $response = $this->post(route('register.post'), [
        'name' => 'Fahad Al-Harbi',
        'email' => 'fahad@example.com',
        'phone' => '+966512345678',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'gender' => 'male',
        'date_of_birth' => '1996-05-15',
    ]);

    $response->assertRedirect(route('patient.dashboard'));

    $this->assertDatabaseHas('users', [
        'email' => 'fahad@example.com',
        'role' => UserRole::Patient->value,
    ]);

    $this->assertAuthenticated();
});

test('patient cannot register with already registered email', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->post(route('register.post'), [
        'name' => 'Duplicate User',
        'email' => 'existing@example.com',
        'phone' => '+966512345678',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('registered patient can login successfully', function () {
    $user = User::factory()->create([
        'email' => 'patient@test.com',
        'password' => Hash::make('secret123'),
        'role' => UserRole::Patient,
    ]);

    $response = $this->post(route('login.post'), [
        'email' => 'patient@test.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('patient.dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('doctor logs in and is redirected to doctor dashboard', function () {
    $doctorUser = User::factory()->create([
        'email' => 'doctor@test.com',
        'password' => Hash::make('secret123'),
        'role' => UserRole::Doctor,
    ]);

    Doctor::create([
        'user_id' => $doctorUser->id,
        'specialization' => 'Orthodontics',
        'experience_years' => 7,
        'consultation_fee' => 50,
        'is_active' => true,
    ]);

    $response = $this->post(route('login.post'), [
        'email' => 'doctor@test.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('doctor.dashboard'));
    $this->assertAuthenticatedAs($doctorUser);
});

test('admin logs in and is redirected to admin dashboard', function () {
    $adminUser = User::factory()->create([
        'email' => 'admin@test.com',
        'password' => Hash::make('secret123'),
        'role' => UserRole::Admin,
    ]);

    $response = $this->post(route('login.post'), [
        'email' => 'admin@test.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($adminUser);
});

test('unauthorized patient is prohibited from accessing admin console', function () {
    $patient = User::factory()->create([
        'role' => UserRole::Patient,
    ]);

    $response = $this->actingAs($patient)->get(route('admin.dashboard'));
    $response->assertStatus(403);
});
