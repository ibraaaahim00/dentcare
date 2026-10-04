<?php

namespace App\Repositories\Contracts;

use App\Models\CtaSection;

interface CtaSectionRepositoryInterface extends BaseRepositoryInterface
{
    public function getActive(): ?CtaSection;
}
