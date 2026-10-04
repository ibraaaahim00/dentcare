<?php

namespace App\Repositories\Eloquent;

use App\Models\GalleryItem;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GalleryItemRepository extends BaseRepository implements GalleryItemRepositoryInterface
{
    public function __construct(GalleryItem $model)
    {
        parent::__construct($model);
    }

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    public function toggleActive(int $id): bool
    {
        $item = $this->findById($id);
        if (! $item) {
            return false;
        }

        return $item->update(['is_active' => ! $item->is_active]);
    }
}
