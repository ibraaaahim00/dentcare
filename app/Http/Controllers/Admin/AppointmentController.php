<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\UpdateAppointmentStatusRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Services\AppointmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepository,
        protected AppointmentService $appointmentService
    ) {}

    public function index(Request $request): View
    {
        $appointments = $this->appointmentRepository->getAllAppointments($request->all(), 12);
        $doctors = Doctor::active()->with('user')->get();

        return view('admin.appointments.index', compact('appointments', 'doctors'));
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['patient', 'doctor.user', 'service', 'medicalRecord', 'review']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, Appointment $appointment): RedirectResponse
    {
        $status = AppointmentStatus::from($request->status);

        $this->appointmentService->updateStatus(
            $appointment,
            $status,
            $request->cancellation_reason,
            $request->doctor_notes
        );

        return redirect()->route('admin.appointments.show', $appointment->id)
            ->with('success', __('appointments.success.updated'));
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
