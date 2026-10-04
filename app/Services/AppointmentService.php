<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\AppointmentSetting;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingHour;
use App\Notifications\AppointmentBookedNotification;
use App\Notifications\AppointmentStatusChangedNotification;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentService
{
    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepository
    ) {}

    /**
     * Get available time slots for a given doctor, date, and service.
     *
     * @return array<int, array{time: string, end_time: string, available: bool, reason?: string}>
     */
    public function getAvailableSlots(int $doctorId, string $date, ?int $serviceId = null): array
    {
        $appointmentDate = Carbon::parse($date)->startOfDay();
        $today = Carbon::today();
        $settings = AppointmentSetting::current();

        // 1. Cannot book in the past
        if ($appointmentDate->lt($today)) {
            return [];
        }

        // 2. Cannot book beyond maximum_days_ahead
        $maxDate = $today->copy()->addDays($settings->maximum_days_ahead);
        if ($appointmentDate->gt($maxDate)) {
            return [];
        }

        // 3. Check clinic working hours for this day of the week
        $dayOfWeek = $appointmentDate->dayOfWeek; // 0 = Sunday, ..., 6 = Saturday
        $workingHour = WorkingHour::where('day_of_week', $dayOfWeek)->first();

        if (! $workingHour || $workingHour->is_closed) {
            return [];
        }

        // 4. Determine service duration
        $duration = 30; // default minutes
        if ($serviceId) {
            $service = Service::find($serviceId);
            if ($service && $service->duration > 0) {
                $duration = $service->duration;
            }
        }

        $interval = max(15, (int) $settings->booking_interval);

        // 5. Existing appointments for the doctor on this date
        $existingAppointments = $this->appointmentRepository->getAppointmentsForDoctorOnDate($doctorId, $appointmentDate->toDateString());

        // 6. Generate slots
        $slots = [];
        $startTime = Carbon::parse($appointmentDate->toDateString().' '.$workingHour->start_time);
        $clinicEndTime = Carbon::parse($appointmentDate->toDateString().' '.$workingHour->end_time);
        $minimumNoticeTime = Carbon::now()->addHours($settings->minimum_notice_hours);

        $currentSlotStart = $startTime->copy();

        while ($currentSlotStart->copy()->addMinutes($duration)->lte($clinicEndTime)) {
            $currentSlotEnd = $currentSlotStart->copy()->addMinutes($duration);
            $slotStartStr = $currentSlotStart->format('H:i:s');
            $slotEndStr = $currentSlotEnd->format('H:i:s');

            $isAvailable = true;
            $reason = null;

            // Check if slot start is before minimum notice time (for today)
            if ($currentSlotStart->lt($minimumNoticeTime)) {
                $isAvailable = false;
                $reason = 'Notice period passed';
            } else {
                // Check conflict with doctor's appointments
                foreach ($existingAppointments as $existing) {
                    $existingStart = $existing->start_time;
                    $existingEnd = $existing->end_time;

                    // Overlap: existingStart < slotEnd && existingEnd > slotStart
                    if ($existingStart < $slotEndStr && $existingEnd > $slotStartStr) {
                        $isAvailable = false;
                        $reason = 'Slot already booked';
                        break;
                    }
                }
            }

            $slots[] = [
                'time' => $currentSlotStart->format('H:i'),
                'end_time' => $currentSlotEnd->format('H:i'),
                'time_full' => $slotStartStr,
                'end_time_full' => $slotEndStr,
                'available' => $isAvailable,
                'reason' => $reason,
            ];

            $currentSlotStart->addMinutes($interval);
        }

        return $slots;
    }

    /**
     * Book a new appointment with strict validation and database transaction.
     *
     * @throws ValidationException
     */
    public function bookAppointment(array $data, User $patient): Appointment
    {
        $settings = AppointmentSetting::current();
        $date = Carbon::parse($data['appointment_date'])->startOfDay();
        $today = Carbon::today();

        // Validate date bounds
        if ($date->lt($today)) {
            throw ValidationException::withMessages([
                'appointment_date' => [__('appointments.errors.past_date')],
            ]);
        }

        $maxDate = $today->copy()->addDays($settings->maximum_days_ahead);
        if ($date->gt($maxDate)) {
            throw ValidationException::withMessages([
                'appointment_date' => [__('appointments.errors.max_days_exceeded', ['days' => $settings->maximum_days_ahead])],
            ]);
        }

        // Validate working hours
        $dayOfWeek = $date->dayOfWeek;
        $workingHour = WorkingHour::where('day_of_week', $dayOfWeek)->first();

        if (! $workingHour || $workingHour->is_closed) {
            throw ValidationException::withMessages([
                'appointment_date' => [__('appointments.errors.day_closed')],
            ]);
        }

        // Validate doctor exists and is active
        $doctor = Doctor::active()->findOrFail($data['doctor_id']);

        // Validate service exists and is active
        $service = Service::active()->findOrFail($data['service_id']);
        $duration = $service->duration > 0 ? $service->duration : 30;

        // Calculate start and end time
        $startFormatted = Carbon::createFromFormat('H:i', substr($data['start_time'], 0, 5))->format('H:i:s');
        $slotStartDateTime = Carbon::parse($date->toDateString().' '.$startFormatted);
        $slotEndDateTime = $slotStartDateTime->copy()->addMinutes($duration);
        $endFormatted = $slotEndDateTime->format('H:i:s');

        // Check clinic working hours range
        $clinicStartTime = Carbon::parse($date->toDateString().' '.$workingHour->start_time);
        $clinicEndTime = Carbon::parse($date->toDateString().' '.$workingHour->end_time);

        if ($slotStartDateTime->lt($clinicStartTime) || $slotEndDateTime->gt($clinicEndTime)) {
            throw ValidationException::withMessages([
                'start_time' => [__('appointments.errors.outside_hours')],
            ]);
        }

        // Check minimum notice hours
        $minimumNoticeTime = Carbon::now()->addHours($settings->minimum_notice_hours);
        if ($slotStartDateTime->lt($minimumNoticeTime)) {
            throw ValidationException::withMessages([
                'start_time' => [__('appointments.errors.minimum_notice', ['hours' => $settings->minimum_notice_hours])],
            ]);
        }

        // Perform booking within database transaction
        return DB::transaction(function () use ($patient, $doctor, $service, $date, $startFormatted, $endFormatted, $data) {
            // Check double booking / conflict
            $hasConflict = $this->appointmentRepository->hasConflict(
                $doctor->id,
                $date->toDateString(),
                $startFormatted,
                $endFormatted
            );

            if ($hasConflict) {
                throw ValidationException::withMessages([
                    'start_time' => [__('appointments.errors.slot_taken')],
                ]);
            }

            /** @var Appointment $appointment */
            $appointment = $this->appointmentRepository->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'service_id' => $service->id,
                'appointment_date' => $date->toDateString(),
                'start_time' => $startFormatted,
                'end_time' => $endFormatted,
                'status' => AppointmentStatus::Pending,
                'patient_notes' => $data['patient_notes'] ?? null,
            ]);

            // Notify patient
            $patient->notify(new AppointmentBookedNotification($appointment));

            return $appointment;
        });
    }

    /**
     * Update appointment status with lifecycle rules.
     *
     * @throws ValidationException
     */
    public function updateStatus(
        Appointment $appointment,
        AppointmentStatus $newStatus,
        ?string $reason = null,
        ?string $doctorNotes = null
    ): Appointment {
        if (! $appointment->status->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => [__('appointments.errors.invalid_transition', [
                    'from' => $appointment->status->label(),
                    'to' => $newStatus->label(),
                ])],
            ]);
        }

        $attributes = [
            'status' => $newStatus,
        ];

        if ($doctorNotes !== null) {
            $attributes['doctor_notes'] = $doctorNotes;
        }

        if ($newStatus === AppointmentStatus::Confirmed) {
            $attributes['confirmed_at'] = Carbon::now();
        } elseif ($newStatus === AppointmentStatus::Completed) {
            $attributes['completed_at'] = Carbon::now();
        } elseif ($newStatus === AppointmentStatus::Cancelled) {
            $attributes['cancelled_at'] = Carbon::now();
            if ($reason) {
                $attributes['cancellation_reason'] = $reason;
            }
        }

        $appointment->update($attributes);

        // Notify patient of status update
        $appointment->patient->notify(new AppointmentStatusChangedNotification($appointment));

        return $appointment;
    }

    /**
     * Cancel appointment by patient according to clinic cancellation policy.
     *
     * @throws ValidationException
     */
    public function cancelByPatient(Appointment $appointment, User $patient, ?string $reason = null): Appointment
    {
        if ($appointment->patient_id !== $patient->id) {
            throw ValidationException::withMessages([
                'appointment' => [__('appointments.errors.unauthorized_cancel')],
            ]);
        }

        $settings = AppointmentSetting::current();

        if (! $appointment->canBeCancelledByPatient($settings->cancellation_hours)) {
            throw ValidationException::withMessages([
                'cancellation' => [__('appointments.errors.cancel_deadline_passed', ['hours' => $settings->cancellation_hours])],
            ]);
        }

        return $this->updateStatus($appointment, AppointmentStatus::Cancelled, $reason ?? 'Cancelled by patient');
    }
}
