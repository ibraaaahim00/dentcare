<?php

namespace App\Repositories\Contracts;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function getPatientsPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getByRole(UserRole $role): LengthAwarePaginator;
}
