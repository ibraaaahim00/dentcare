<?php

namespace App\Repositories\Contracts;

use App\Models\AboutSection;

interface AboutSectionRepositoryInterface extends BaseRepositoryInterface
{
    public function getActive(): ?AboutSection;
}
