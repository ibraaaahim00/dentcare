<?php

namespace App\Repositories\Eloquent;

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    public function getPatientsPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->where('role', UserRole::Patient)
            ->withCount('appointments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function getByRole(UserRole $role): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->where('role', $role)
            ->latest()
            ->paginate();
    }
}
