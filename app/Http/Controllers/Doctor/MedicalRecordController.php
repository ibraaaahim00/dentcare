<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecord\StoreMedicalRecordRequest;
use App\Models\Appointment;
use App\Services\MedicalRecordService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected MedicalRecordService $medicalRecordService
    ) {}

    public function create(Request $request): View
    {
        $doctor = $request->user()->doctor;
        $appointment = null;

        if ($request->query('appointment_id')) {
            $appointment = Appointment::where('doctor_id', $doctor->id)
                ->with(['patient', 'service'])
                ->findOrFail($request->query('appointment_id'));
        }

        return view('doctor.medical-records.create', compact('appointment', 'doctor'));
    }

    public function store(StoreMedicalRecordRequest $request): RedirectResponse
    {
        $doctor = $request->user()->doctor;

        $record = $this->medicalRecordService->recordTreatment($doctor, $request->validated());

        if ($record->appointment_id) {
            return redirect()->route('doctor.appointments.show', $record->appointment_id)
                ->with('success', 'Medical record added successfully.');
        }

        return redirect()->route('doctor.patients.show', $record->patient_id)
            ->with('success', 'Medical record created successfully.');
    }
}
