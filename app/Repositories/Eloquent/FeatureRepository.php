<?php

namespace App\Repositories\Eloquent;

use App\Models\Feature;
use App\Repositories\Contracts\FeatureRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FeatureRepository extends BaseRepository implements FeatureRepositoryInterface
{
    public function __construct(Feature $model)
    {
        parent::__construct($model);
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }
}
