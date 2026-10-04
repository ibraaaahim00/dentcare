<?php

namespace App\Repositories\Eloquent;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AppointmentRepository extends BaseRepository implements AppointmentRepositoryInterface
{
    public function __construct(Appointment $model)
    {
        parent::__construct($model);
    }

    public function getAppointmentsForDoctorOnDate(int $doctorId, string $date): Collection
    {
        return $this->model->newQuery()
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', [AppointmentStatus::Pending, AppointmentStatus::Confirmed])
            ->orderBy('start_time')
            ->get();
    }

    public function hasConflict(int $doctorId, string $date, string $startTime, string $endTime, ?int $ignoreAppointmentId = null): bool
    {
        $query = $this->model->newQuery()
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', [AppointmentStatus::Pending, AppointmentStatus::Confirmed])
            ->where(function ($q) use ($startTime, $endTime) {
                // Overlap condition: existing_start < new_end AND existing_end > new_start
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($ignoreAppointmentId) {
            $query->where('id', '!=', $ignoreAppointmentId);
        }

        return $query->exists();
    }

    public function getDoctorAppointments(int $doctorId, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->where('doctor_id', $doctorId)
            ->with(['patient', 'service', 'medicalRecord'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    public function getPatientAppointments(int $patientId, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->where('patient_id', $patientId)
            ->with(['doctor.user', 'service', 'medicalRecord', 'review'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    public function getAllAppointments(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['patient', 'doctor.user', 'service']);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['doctor_id'])) {
            $query->where('doctor_id', $filters['doctor_id']);
        }

        if (! empty($filters['date'])) {
            $query->whereDate('appointment_date', $filters['date']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($p) use ($search) {
                    $p->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('doctor.user', function ($d) use ($search) {
                    $d->where('name', 'like', "%{$search}%");
                });
            });
        }

        return $query->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->paginate($perPage);
    }

    public function getTodayAppointments(): Collection
    {
        return $this->model->newQuery()
            ->whereDate('appointment_date', Carbon::today())
            ->with(['patient', 'doctor.user', 'service'])
            ->orderBy('start_time')
            ->get();
    }

    public function getRecentAppointments(int $limit = 5): Collection
    {
        return $this->model->newQuery()
            ->with(['patient', 'doctor.user', 'service'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function countByStatus(AppointmentStatus $status): int
    {
        return $this->model->newQuery()->where('status', $status)->count();
    }

    public function findWithDetails(int|string $id): ?Appointment
    {
        return $this->model->newQuery()
            ->with(['patient', 'doctor.user', 'service', 'medicalRecord', 'review'])
            ->find($id);
    }
}
