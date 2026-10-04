<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\CancelAppointmentRequest;
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
        $appointments = $this->appointmentRepository->getPatientAppointments(
            $request->user()->id,
            $request->query('status'),
            10
        );

        return view('patient.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment): View
    {
        $this->authorize('view', $appointment);

        $appointment->load(['doctor.user', 'service', 'medicalRecord', 'review']);

        return view('patient.appointments.show', compact('appointment'));
    }

    public function cancel(CancelAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $this->authorize('cancel', $appointment);

        $this->appointmentService->cancelByPatient(
            $appointment,
            $request->user(),
            $request->validated('cancellation_reason')
        );

        return redirect()->route('patient.appointments.show', $appointment->id)
            ->with('success', __('appointments.success.cancelled'));
    }
}
