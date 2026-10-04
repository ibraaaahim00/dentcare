<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContactMessageRepositoryInterface extends BaseRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $status = null): LengthAwarePaginator;

    public function getUnreadCount(): int;
}
