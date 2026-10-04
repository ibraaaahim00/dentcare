<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AppointmentStatus;
use App\Http\Requests\Appointment\CancelAppointmentRequest;
use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentStatusRequest;
use App\Http\Resources\Api\AppointmentResource;
use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Services\AppointmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends BaseApiController
{
    use AuthorizesRequests;

    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepository,
        protected AppointmentService $appointmentService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->isDoctor() && $user->doctor) {
            $appointments = $this->appointmentRepository->getDoctorAppointments($user->doctor->id, $request->status);
        } elseif ($user->isAdmin()) {
            $appointments = $this->appointmentRepository->getAllAppointments($request->all());
        } else {
            $appointments = $this->appointmentRepository->getPatientAppointments($user->id, $request->status);
        }

        return $this->successResponse(
            AppointmentResource::collection($appointments),
            null,
            200,
            [
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
            ]
        );
    }

    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $appointment = $this->appointmentService->bookAppointment(
            $request->validated(),
            $request->user()
        );

        return $this->successResponse(
            new AppointmentResource($appointment->load(['doctor.user', 'service'])),
            'Appointment booked successfully',
            201
        );
    }

    public function show(Appointment $appointment): JsonResponse
    {
        $this->authorize('view', $appointment);

        return $this->successResponse(
            new AppointmentResource($appointment->load(['patient', 'doctor.user', 'service', 'medicalRecord', 'review']))
        );
    }

    public function update(UpdateAppointmentStatusRequest $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('update', $appointment);

        $status = AppointmentStatus::from($request->status);

        $updated = $this->appointmentService->updateStatus(
            $appointment,
            $status,
            $request->cancellation_reason,
            $request->doctor_notes
        );

        return $this->successResponse(
            new AppointmentResource($updated->load(['doctor.user', 'service'])),
            'Appointment updated successfully'
        );
    }

    public function destroy(CancelAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('cancel', $appointment);

        $cancelled = $this->appointmentService->cancelByPatient(
            $appointment,
            $request->user(),
            $request->cancellation_reason
        );

        return $this->successResponse(
            new AppointmentResource($cancelled),
            'Appointment cancelled successfully'
        );
    }
}
