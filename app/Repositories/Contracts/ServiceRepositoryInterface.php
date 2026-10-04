<?php

namespace App\Repositories\Contracts;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ServiceRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveServices(): Collection;

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function findBySlug(string $slug): ?Service;
}
