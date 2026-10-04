<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Service;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Services\DoctorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function __construct(
        protected DoctorRepositoryInterface $doctorRepository,
        protected DoctorService $doctorService
    ) {}

    public function index(Request $request): View
    {
        $doctors = $this->doctorRepository->getPaginatedWithUser(10, $request->query('search'));

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create(): View
    {
        $services = Service::active()->get();

        return view('admin.doctors.create', compact('services'));
    }

    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ];

        $doctorData = [
            'specialization' => $validated['specialization'],
            'bio' => $validated['bio'] ?? null,
            'qualifications' => $validated['qualifications'] ?? null,
            'experience_years' => $validated['experience_years'],
            'consultation_fee' => $validated['consultation_fee'],
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        $this->doctorService->createDoctor(
            $userData,
            $doctorData,
            $request->file('image'),
            $validated['services'] ?? []
        );

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function edit(Doctor $doctor): View
    {
        $doctor->load(['user', 'services']);
        $services = Service::active()->get();

        return view('admin.doctors.edit', compact('doctor', 'services'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validated();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];

        if (! empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }

        $doctorData = [
            'specialization' => $validated['specialization'],
            'bio' => $validated['bio'] ?? null,
            'qualifications' => $validated['qualifications'] ?? null,
            'experience_years' => $validated['experience_years'],
            'consultation_fee' => $validated['consultation_fee'],
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        $this->doctorService->updateDoctor(
            $doctor,
            $userData,
            $doctorData,
            $request->file('image'),
            $validated['services'] ?? []
        );

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $this->doctorService->deleteDoctor($doctor);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
