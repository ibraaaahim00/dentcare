<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface HeroBannerRepositoryInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
}
