<?php

namespace App\Repositories\Eloquent;

use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }

    public function getActiveServices(): Collection
    {
        return $this->model->newQuery()
            ->active()
            ->orderBy('sort_order')
            ->get();
    }

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->withCount('appointments');

        if ($search) {
            $query->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%")
                ->orWhere('description_ar', 'like', "%{$search}%")
                ->orWhere('description_en', 'like', "%{$search}%");
        }

        return $query->orderBy('sort_order')->paginate($perPage);
    }

    public function findBySlug(string $slug): ?Service
    {
        return $this->model->newQuery()->where('slug', $slug)->first();
    }
}
