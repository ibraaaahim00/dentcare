<?php

namespace App\Repositories\Contracts;

use App\Models\BlogPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BlogPostRepositoryInterface extends BaseRepositoryInterface
{
    public function getPublishedPaginated(int $perPage = 9, ?string $categorySlug = null, ?string $search = null): LengthAwarePaginator;

    public function getRecentPublished(int $limit = 3): Collection;

    public function findBySlug(string $slug): ?BlogPost;

    public function getAllPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;
}
