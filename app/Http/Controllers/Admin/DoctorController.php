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
            'specialization' => $validated['specialization'] ?? ($validated['specialization_en'] ?? ($validated['specialization_ar'] ?? 'Dentist')),
            'specialization_ar' => $validated['specialization_ar'] ?? null,
            'specialization_en' => $validated['specialization_en'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'bio_ar' => $validated['bio_ar'] ?? null,
            'bio_en' => $validated['bio_en'] ?? null,
            'qualifications' => $validated['qualifications'] ?? null,
            'qualifications_ar' => $validated['qualifications_ar'] ?? null,
            'qualifications_en' => $validated['qualifications_en'] ?? null,
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
            'specialization' => $validated['specialization'] ?? ($validated['specialization_en'] ?? ($validated['specialization_ar'] ?? 'Dentist')),
            'specialization_ar' => $validated['specialization_ar'] ?? null,
            'specialization_en' => $validated['specialization_en'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'bio_ar' => $validated['bio_ar'] ?? null,
            'bio_en' => $validated['bio_en'] ?? null,
            'qualifications' => $validated['qualifications'] ?? null,
            'qualifications_ar' => $validated['qualifications_ar'] ?? null,
            'qualifications_en' => $validated['qualifications_en'] ?? null,
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

    public function editSchedule(Doctor $doctor): View
    {
        $doctor->load('schedules');
        $schedules = $doctor->schedules->keyBy('day_of_week');

        return view('admin.doctors.schedule', compact('doctor', 'schedules'));
    }

    public function updateSchedule(Request $request, Doctor $doctor): RedirectResponse
    {
        $days = $request->input('days', []);

        foreach ($days as $dayIndex => $dayData) {
            $doctor->schedules()->updateOrCreate(
                ['day_of_week' => (int) $dayIndex],
                [
                    'start_time' => $dayData['start_time'] ?? '09:00:00',
                    'end_time' => $dayData['end_time'] ?? '17:00:00',
                    'break_start' => ! empty($dayData['break_start']) ? $dayData['break_start'] : null,
                    'break_end' => ! empty($dayData['break_end']) ? $dayData['break_end'] : null,
                    'is_day_off' => isset($dayData['is_day_off']),
                ]
            );
        }

        return redirect()->route('admin.doctors.schedule.edit', $doctor)
            ->with('success', __('Doctor schedule updated successfully.'));
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $this->doctorService->deleteDoctor($doctor);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
