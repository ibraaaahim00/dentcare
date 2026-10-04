<?php

namespace App\Repositories\Eloquent;

use App\Models\Statistic;
use App\Repositories\Contracts\StatisticRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StatisticRepository extends BaseRepository implements StatisticRepositoryInterface
{
    public function __construct(Statistic $model)
    {
        parent::__construct($model);
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }
}
