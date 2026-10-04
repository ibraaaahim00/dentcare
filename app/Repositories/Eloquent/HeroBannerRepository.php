<?php

namespace App\Repositories\Eloquent;

use App\Models\HeroBanner;
use App\Repositories\Contracts\HeroBannerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HeroBannerRepository extends BaseRepository implements HeroBannerRepositoryInterface
{
    public function __construct(HeroBanner $model)
    {
        parent::__construct($model);
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }
}
