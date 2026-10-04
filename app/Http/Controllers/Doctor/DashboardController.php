<?php

namespace App\Http\Controllers\Doctor;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $doctor = $request->user()->doctor;

        if (! $doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->with(['patient', 'service'])
            ->orderBy('start_time')
            ->get();

        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->upcoming()
            ->with(['patient', 'service'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $stats = [
            'today_count' => $todayAppointments->count(),
            'pending_count' => Appointment::where('doctor_id', $doctor->id)->where('status', AppointmentStatus::Pending)->count(),
            'completed_count' => Appointment::where('doctor_id', $doctor->id)->where('status', AppointmentStatus::Completed)->count(),
            'medical_records_count' => MedicalRecord::where('doctor_id', $doctor->id)->count(),
        ];

        return view('doctor.dashboard', compact('doctor', 'todayAppointments', 'upcomingAppointments', 'stats'));
    }
}
