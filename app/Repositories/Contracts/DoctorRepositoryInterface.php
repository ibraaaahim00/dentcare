<?php

namespace App\Repositories\Contracts;

use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface DoctorRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveDoctors(): Collection;

    public function getPaginatedWithUser(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function findWithDetails(int|string $id): ?Doctor;

    public function getDoctorsForService(int $serviceId): Collection;
}
