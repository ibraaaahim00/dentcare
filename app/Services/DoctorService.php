<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Doctor;
use App\Models\User;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class DoctorService
{
    public function __construct(
        protected DoctorRepositoryInterface $doctorRepository,
        protected UserRepositoryInterface $userRepository,
        protected FileUploadService $fileUploadService
    ) {}

    /**
     * Create a doctor along with their user profile and service links.
     */
    public function createDoctor(array $userData, array $doctorData, ?UploadedFile $image = null, array $serviceIds = []): Doctor
    {
        return DB::transaction(function () use ($userData, $doctorData, $image, $serviceIds) {
            $userData['role'] = UserRole::Doctor;
            /** @var User $user */
            $user = $this->userRepository->create($userData);

            if ($image) {
                $doctorData['image'] = $this->fileUploadService->upload($image, 'doctors');
            }

            $doctorData['user_id'] = $user->id;
            /** @var Doctor $doctor */
            $doctor = $this->doctorRepository->create($doctorData);

            if (! empty($serviceIds)) {
                $doctor->services()->sync($serviceIds);
            }

            return $doctor;
        });
    }

    /**
     * Update doctor profile, user info, services, and image.
     */
    public function updateDoctor(Doctor $doctor, array $userData, array $doctorData, ?UploadedFile $image = null, ?array $serviceIds = null): Doctor
    {
        return DB::transaction(function () use ($doctor, $userData, $doctorData, $image, $serviceIds) {
            if (! empty($userData)) {
                $doctor->user->update($userData);
            }

            if ($image) {
                $doctorData['image'] = $this->fileUploadService->replace($doctor->image, $image, 'doctors');
            }

            $doctor->update($doctorData);

            if ($serviceIds !== null) {
                $doctor->services()->sync($serviceIds);
            }

            return $doctor->refresh();
        });
    }

    /**
     * Delete doctor and associated user profile and uploaded image.
     */
    public function deleteDoctor(Doctor $doctor): bool
    {
        return DB::transaction(function () use ($doctor) {
            if ($doctor->image) {
                $this->fileUploadService->delete($doctor->image);
            }

            $user = $doctor->user;
            $doctor->delete();
            $user?->delete();

            return true;
        });
    }
}
