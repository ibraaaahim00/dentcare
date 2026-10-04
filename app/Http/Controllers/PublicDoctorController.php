<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicDoctorController extends Controller
{
    public function __construct(
        protected DoctorRepositoryInterface $doctorRepository,
        protected AppointmentService $appointmentService
    ) {}

    public function index(): View
    {
        $doctors = $this->doctorRepository->getActiveDoctors();

        return view('pages.doctors.index', compact('doctors'));
    }

    public function show(int $id): View
    {
        $doctor = $this->doctorRepository->findWithDetails($id);

        if (! $doctor || ! $doctor->is_active) {
            abort(404);
        }

        return view('pages.doctors.show', compact('doctor'));
    }

    public function availableSlots(Request $request, Doctor $doctor): JsonResponse
    {
        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'service_id' => ['nullable', 'integer', 'exists:services,id'],
        ]);

        $slots = $this->appointmentService->getAvailableSlots(
            $doctor->id,
            $request->date,
            $request->service_id ? (int) $request->service_id : null
        );

        return response()->json([
            'success' => true,
            'data' => $slots,
        ]);
    }
}
