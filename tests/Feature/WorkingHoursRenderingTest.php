<?php

use App\Models\WorkingHour;
use Illuminate\Support\Facades\Cache;

test('login page renders working hours from working hour models', function () {
    WorkingHour::create([
        'day_of_week' => 0,
        'start_time' => '09:00:00',
        'end_time' => '21:00:00',
        'is_closed' => false,
    ]);

    $response = $this->get(route('login'));

    $response->assertOk();
    $response->assertSee('Sunday');
    $response->assertSee('09:00 PM');
});
test('login page ignores legacy cached working hours data', function () {
    Cache::put('clinic_working_hours_list', ['legacy cached value']);
    WorkingHour::create([
        'day_of_week' => 1,
        'start_time' => '10:00:00',
        'end_time' => '18:00:00',
        'is_closed' => false,
    ]);

    $response = $this->get(route('login'));

    $response->assertOk();
    $response->assertSee('Monday');
    $response->assertDontSee('legacy cached value');
});
