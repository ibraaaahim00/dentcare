<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface GalleryItemRepositoryInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;

    public function toggleActive(int $id): bool;
}
