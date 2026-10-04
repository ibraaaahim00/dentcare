<?php

namespace App\Repositories\Eloquent;

use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class DoctorRepository extends BaseRepository implements DoctorRepositoryInterface
{
    public function __construct(Doctor $model)
    {
        parent::__construct($model);
    }

    public function getActiveDoctors(): Collection
    {
        return $this->model->newQuery()
            ->active()
            ->with(['user', 'services'])
            ->orderBy('sort_order')
            ->get();
    }

    public function getPaginatedWithUser(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['user', 'services']);

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })->orWhere('specialization', 'like', "%{$search}%");
        }

        return $query->orderBy('sort_order')->paginate($perPage);
    }

    public function findWithDetails(int|string $id): ?Doctor
    {
        return $this->model->newQuery()
            ->with(['user', 'services', 'reviews.patient'])
            ->find($id);
    }

    public function getDoctorsForService(int $serviceId): Collection
    {
        return $this->model->newQuery()
            ->active()
            ->whereHas('services', function ($q) use ($serviceId) {
                $q->where('services.id', $serviceId);
            })
            ->with('user')
            ->orderBy('sort_order')
            ->get();
    }
}
