<?php

use App\Enums\UserRole;
use App\Models\ClinicSetting;
use App\Models\User;

test('admin can change the display name shown across the dashboard', function () {
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $settings = ClinicSetting::query()->pluck('value', 'key')->toArray();

    $response = $this->actingAs($admin)->post(route('admin.settings.update-clinic'), array_merge($settings, [
        'admin_name' => 'Custom Dashboard Name',
        'booking_interval' => 30,
        'minimum_notice_hours' => 2,
        'maximum_days_ahead' => 30,
        'cancellation_hours' => 4,
    ]));

    $response->assertRedirect(route('admin.settings.index'));
    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'name' => 'Custom Dashboard Name',
    ]);

    $dashboard = $this->actingAs($admin)->get(route('admin.dashboard'));

    $dashboard->assertSee('Custom Dashboard Name');
});
test('settings page shows the current admin display name', function () {
    $this->artisan('db:seed', ['--class' => 'ClinicSettingSeeder']);
    $admin = User::factory()->create([
        'role' => UserRole::Admin,
        'name' => 'Current Admin Name',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.settings.index'));

    $response->assertOk();
    $response->assertSee('Current Admin Name');
});
