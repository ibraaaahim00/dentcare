<?php

namespace App\Http\Controllers\Patient;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $upcomingAppointments = Appointment::where('patient_id', $user->id)
            ->upcoming()
            ->with(['doctor.user', 'service'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->take(3)
            ->get();

        $recentAppointments = Appointment::where('patient_id', $user->id)
            ->with(['doctor.user', 'service', 'review'])
            ->latest('appointment_date')
            ->take(5)
            ->get();

        $stats = [
            'total_appointments' => Appointment::where('patient_id', $user->id)->count(),
            'completed_appointments' => Appointment::where('patient_id', $user->id)->where('status', AppointmentStatus::Completed)->count(),
            'upcoming_count' => Appointment::where('patient_id', $user->id)->upcoming()->count(),
            'medical_records_count' => MedicalRecord::where('patient_id', $user->id)->count(),
        ];

        return view('patient.dashboard', compact('upcomingAppointments', 'recentAppointments', 'stats'));
    }
}
