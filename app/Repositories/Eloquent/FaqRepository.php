<?php

namespace App\Repositories\Eloquent;

use App\Models\Faq;
use App\Repositories\Contracts\FaqRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FaqRepository extends BaseRepository implements FaqRepositoryInterface
{
    public function __construct(Faq $model)
    {
        parent::__construct($model);
    }

    public function getActive(?int $limit = null): Collection
    {
        $query = $this->model->where('is_active', true)->orderBy('sort_order')->orderBy('id');

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    public function toggleActive(int $id): bool
    {
        $faq = $this->findById($id);
        if (! $faq) {
            return false;
        }

        return $faq->update(['is_active' => ! $faq->is_active]);
    }
}
