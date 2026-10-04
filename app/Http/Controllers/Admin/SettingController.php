<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateClinicSettingsRequest;
use App\Http\Requests\Settings\UpdateWorkingHoursRequest;
use App\Models\AppointmentSetting;
use App\Models\ClinicSetting;
use App\Models\WorkingHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = ClinicSetting::all()->pluck('value', 'key');
        $appointmentSettings = AppointmentSetting::current();
        $workingHours = WorkingHour::orderBy('day_of_week')->get();

        return view('admin.settings.index', compact('settings', 'appointmentSettings', 'workingHours'));
    }

    public function updateClinicSettings(UpdateClinicSettingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        ClinicSetting::set('clinic_name_ar', $validated['clinic_name_ar']);
        ClinicSetting::set('clinic_name_en', $validated['clinic_name_en']);
        ClinicSetting::set('email', $validated['email']);
        ClinicSetting::set('phone', $validated['phone']);
        ClinicSetting::set('emergency_phone', $validated['emergency_phone'] ?? '');
        ClinicSetting::set('address_ar', $validated['address_ar']);
        ClinicSetting::set('address_en', $validated['address_en']);

        $appointmentSettings = AppointmentSetting::current();
        $appointmentSettings->update([
            'booking_interval' => $validated['booking_interval'],
            'minimum_notice_hours' => $validated['minimum_notice_hours'],
            'maximum_days_ahead' => $validated['maximum_days_ahead'],
            'cancellation_hours' => $validated['cancellation_hours'],
        ]);
        AppointmentSetting::flushCache();

        return redirect()->route('admin.settings.index')->with('success', 'Clinic settings updated successfully.');
    }

    public function updateWorkingHours(UpdateWorkingHoursRequest $request): RedirectResponse
    {
        $hours = $request->validated('hours');

        foreach ($hours as $hourData) {
            WorkingHour::updateOrCreate(
                ['day_of_week' => $hourData['day_of_week']],
                [
                    'start_time' => $hourData['start_time'],
                    'end_time' => $hourData['end_time'],
                    'is_closed' => ! empty($hourData['is_closed']),
                ]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Working hours updated successfully.');
    }
}
