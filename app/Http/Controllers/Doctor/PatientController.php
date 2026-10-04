<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $doctor = $request->user()->doctor;

        $patientIds = Appointment::where('doctor_id', $doctor->id)
            ->pluck('patient_id')
            ->unique();

        $patients = User::whereIn('id', $patientIds)
            ->withCount(['appointments' => function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            }])
            ->paginate(15);

        return view('doctor.patients.index', compact('patients'));
    }

    public function show(Request $request, User $patient): View
    {
        $doctor = $request->user()->doctor;

        // Ensure patient has appointments with this doctor
        $hasHistory = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->exists();

        if (! $hasHistory) {
            abort(403, 'Unauthorized access to patient medical profile.');
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->with('service')
            ->latest('appointment_date')
            ->get();

        $medicalRecords = MedicalRecord::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->latest('treatment_date')
            ->get();

        return view('doctor.patients.show', compact('patient', 'appointments', 'medicalRecords'));
    }
}
