<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogPost;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BlogPostRepository extends BaseRepository implements BlogPostRepositoryInterface
{
    public function __construct(BlogPost $model)
    {
        parent::__construct($model);
    }

    public function getPublishedPaginated(int $perPage = 9, ?string $categorySlug = null, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->published()
            ->with(['author', 'categories']);

        if ($categorySlug) {
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                    ->orWhere('title_en', 'like', "%{$search}%")
                    ->orWhere('content_ar', 'like', "%{$search}%")
                    ->orWhere('content_en', 'like', "%{$search}%");
            });
        }

        return $query->latest('published_at')->paginate($perPage);
    }

    public function getRecentPublished(int $limit = 3): Collection
    {
        return $this->model->newQuery()
            ->published()
            ->with(['author', 'categories'])
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function findBySlug(string $slug): ?BlogPost
    {
        return $this->model->newQuery()
            ->where('slug', $slug)
            ->with(['author', 'categories'])
            ->first();
    }

    public function getAllPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['author', 'categories']);

        if ($search) {
            $query->where('title_ar', 'like', "%{$search}%")
                ->orWhere('title_en', 'like', "%{$search}%");
        }

        return $query->latest()->paginate($perPage);
    }
}
