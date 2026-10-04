<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface FaqRepositoryInterface extends BaseRepositoryInterface
{
    public function getActive(?int $limit = null): Collection;

    public function toggleActive(int $id): bool;
}
