<?php

namespace App\Repositories\Eloquent;

use App\Models\AboutSection;
use App\Repositories\Contracts\AboutSectionRepositoryInterface;

class AboutSectionRepository extends BaseRepository implements AboutSectionRepositoryInterface
{
    public function __construct(AboutSection $model)
    {
        parent::__construct($model);
    }

    public function getActive(): ?AboutSection
    {
        return $this->model->where('is_active', true)->first();
    }
}
