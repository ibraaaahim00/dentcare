<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReviewRepositoryInterface extends BaseRepositoryInterface
{
    public function getApprovedReviews(int $limit = 6): Collection;

    public function getAllPaginated(int $perPage = 15, ?string $status = null): LengthAwarePaginator;

    public function getForDoctor(int $doctorId): Collection;
}
