<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Models\AppointmentSetting;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use App\Services\AppointmentService;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PublicAppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService,
        protected AuthService $authService
    ) {}

    public function create(Request $request): View
    {
        $services = Service::active()->orderBy('sort_order')->get();
        $doctors = Doctor::active()->with('user')->orderBy('sort_order')->get();
        $settings = AppointmentSetting::current();

        $selectedServiceId = $request->query('service_id');
        $selectedDoctorId = $request->query('doctor_id');

        return view('pages.appointments.create', compact('services', 'doctors', 'settings', 'selectedServiceId', 'selectedDoctorId'));
    }

    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $user = $request->user();

        // If guest user submits booking with user info
        if (! $user) {
            $validatedGuest = $request->validate([
                'patient_name' => ['required', 'string', 'max:255'],
                'patient_email' => ['required', 'email', 'max:255'],
                'patient_phone' => ['required', 'string', 'max:20'],
                'patient_password' => ['nullable', 'string', 'min:8'],
            ]);

            // Find existing user by email or register new patient
            $user = User::where('email', $validatedGuest['patient_email'])->first();

            if (! $user) {
                $user = $this->authService->registerPatient([
                    'name' => $validatedGuest['patient_name'],
                    'email' => $validatedGuest['patient_email'],
                    'phone' => $validatedGuest['patient_phone'],
                    'password' => $validatedGuest['patient_password'] ?? 'DentCare@'.rand(1000, 9999),
                ]);
            }

            Auth::login($user);
        }

        $appointment = $this->appointmentService->bookAppointment(
            $request->validated(),
            $user
        );

        return redirect()->route('patient.appointments.show', $appointment->id)
            ->with('success', __('appointments.success.booked'));
    }
}
