<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecord\StoreMedicalRecordRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    public function __construct(
        protected MedicalRecordRepositoryInterface $medicalRecordRepository
    ) {}

    public function index(Request $request): View
    {
        $records = $this->medicalRecordRepository->getAllPaginated(12, $request->query('search'));

        return view('admin.medical-records.index', compact('records'));
    }

    public function create(): View
    {
        $patients = User::where('role', 'patient')->orderBy('name')->get();
        $doctors = Doctor::active()->with('user')->get();
        $appointments = Appointment::with(['patient', 'doctor.user', 'service'])->latest()->take(30)->get();

        return view('admin.medical-records.create', compact('patients', 'doctors', 'appointments'));
    }

    public function store(StoreMedicalRecordRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['doctor_id'] = $request->input('doctor_id') ?? Doctor::first()->id;

        $this->medicalRecordRepository->create($validated);

        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record created successfully.');
    }

    public function show(MedicalRecord $medicalRecord): View
    {
        $medicalRecord->load(['patient', 'doctor.user', 'appointment.service']);

        return view('admin.medical-records.show', compact('medicalRecord'));
    }

    public function destroy(MedicalRecord $medicalRecord): RedirectResponse
    {
        $medicalRecord->delete();

        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record deleted successfully.');
    }
}
