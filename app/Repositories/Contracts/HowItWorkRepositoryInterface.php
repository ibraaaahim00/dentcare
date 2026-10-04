<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface HowItWorkRepositoryInterface extends BaseRepositoryInterface
{
    public function getActive(): Collection;
}
