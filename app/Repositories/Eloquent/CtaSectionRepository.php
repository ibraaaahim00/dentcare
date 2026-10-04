<?php

namespace App\Repositories\Eloquent;

use App\Models\CtaSection;
use App\Repositories\Contracts\CtaSectionRepositoryInterface;

class CtaSectionRepository extends BaseRepository implements CtaSectionRepositoryInterface
{
    public function __construct(CtaSection $model)
    {
        parent::__construct($model);
    }

    public function getActive(): ?CtaSection
    {
        return $this->model->where('is_active', true)->first();
    }
}
