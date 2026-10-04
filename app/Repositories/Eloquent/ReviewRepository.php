<?php

namespace App\Repositories\Eloquent;

use App\Enums\ReviewStatus;
use App\Models\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function getApprovedReviews(int $limit = 6): Collection
    {
        return $this->model->newQuery()
            ->where('status', ReviewStatus::Approved)
            ->with(['patient', 'doctor.user'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getAllPaginated(int $perPage = 15, ?string $status = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['patient', 'doctor.user', 'appointment.service']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getForDoctor(int $doctorId): Collection
    {
        return $this->model->newQuery()
            ->where('doctor_id', $doctorId)
            ->where('status', ReviewStatus::Approved)
            ->with('patient')
            ->latest()
            ->get();
    }
}
