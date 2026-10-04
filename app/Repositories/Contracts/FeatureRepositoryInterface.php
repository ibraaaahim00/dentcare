<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface FeatureRepositoryInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
}
