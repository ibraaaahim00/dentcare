<?php

namespace App\Http\Controllers\Doctor;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\UpdateAppointmentStatusRequest;
use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Services\AppointmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepository,
        protected AppointmentService $appointmentService
    ) {}

    public function index(Request $request): View
    {
        $doctor = $request->user()->doctor;

        $appointments = $this->appointmentRepository->getDoctorAppointments(
            $doctor->id,
            $request->query('status'),
            12
        );

        return view('doctor.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment): View
    {
        $this->authorize('view', $appointment);

        $appointment->load(['patient', 'service', 'medicalRecord']);

        return view('doctor.appointments.show', compact('appointment'));
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, Appointment $appointment): RedirectResponse
    {
        $this->authorize('update', $appointment);

        $status = AppointmentStatus::from($request->status);

        $this->appointmentService->updateStatus(
            $appointment,
            $status,
            $request->cancellation_reason,
            $request->doctor_notes
        );

        return redirect()->route('doctor.appointments.show', $appointment->id)
            ->with('success', __('appointments.success.updated'));
    }
}
