<?php

namespace App\Repositories\Eloquent;

use App\Models\HowItWork;
use App\Repositories\Contracts\HowItWorkRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HowItWorkRepository extends BaseRepository implements HowItWorkRepositoryInterface
{
    public function __construct(HowItWork $model)
    {
        parent::__construct($model);
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }
}
