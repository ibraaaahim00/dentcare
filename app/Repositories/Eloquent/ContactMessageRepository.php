<?php

namespace App\Repositories\Eloquent;

use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactMessageRepository extends BaseRepository implements ContactMessageRepositoryInterface
{
    public function __construct(ContactMessage $model)
    {
        parent::__construct($model);
    }

    public function getPaginated(int $perPage = 15, ?string $status = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getUnreadCount(): int
    {
        return $this->model->newQuery()->where('status', ContactMessageStatus::Unread)->count();
    }
}
