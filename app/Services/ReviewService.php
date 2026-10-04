<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Enums\ReviewStatus;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    public function __construct(
        protected ReviewRepositoryInterface $reviewRepository
    ) {}

    /**
     * Submit a review for a completed appointment.
     *
     * @throws ValidationException
     */
    public function submitReview(array $data, User $patient): Review
    {
        $appointment = null;
        if (! empty($data['appointment_id'])) {
            $appointment = Appointment::where('id', $data['appointment_id'])
                ->where('patient_id', $patient->id)
                ->first();

            if (! $appointment) {
                throw ValidationException::withMessages([
                    'appointment_id' => [__('reviews.errors.appointment_not_found')],
                ]);
            }

            if ($appointment->status !== AppointmentStatus::Completed) {
                throw ValidationException::withMessages([
                    'appointment_id' => [__('reviews.errors.appointment_not_completed')],
                ]);
            }

            // Check if review already exists for this appointment
            $existing = Review::where('appointment_id', $appointment->id)->first();
            if ($existing) {
                throw ValidationException::withMessages([
                    'appointment_id' => [__('reviews.errors.already_reviewed')],
                ]);
            }

            $data['doctor_id'] = $appointment->doctor_id;
        }

        $data['patient_id'] = $patient->id;
        $data['status'] = ReviewStatus::Approved; // or pending based on clinic policy

        /** @var Review */
        return $this->reviewRepository->create($data);
    }

    public function updateStatus(Review $review, ReviewStatus $status): bool
    {
        return $review->update(['status' => $status]);
    }
}
