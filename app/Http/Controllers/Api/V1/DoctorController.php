<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\DoctorResource;
use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends BaseApiController
{
    public function __construct(
        protected DoctorRepositoryInterface $doctorRepository,
        protected AppointmentService $appointmentService
    ) {}

    public function index(): JsonResponse
    {
        $doctors = $this->doctorRepository->getActiveDoctors();

        return $this->successResponse(DoctorResource::collection($doctors));
    }

    public function show(Doctor $doctor): JsonResponse
    {
        return $this->successResponse(new DoctorResource($doctor->load(['user', 'services', 'reviews.patient'])));
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

        return $this->successResponse($slots);
    }
}
