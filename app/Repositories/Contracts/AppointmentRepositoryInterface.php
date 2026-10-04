<?php

namespace App\Repositories\Contracts;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AppointmentRepositoryInterface extends BaseRepositoryInterface
{
    public function getAppointmentsForDoctorOnDate(int $doctorId, string $date): Collection;

    public function hasConflict(int $doctorId, string $date, string $startTime, string $endTime, ?int $ignoreAppointmentId = null): bool;

    public function getDoctorAppointments(int $doctorId, ?string $status = null, int $perPage = 15): LengthAwarePaginator;

    public function getPatientAppointments(int $patientId, ?string $status = null, int $perPage = 15): LengthAwarePaginator;

    public function getAllAppointments(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function getTodayAppointments(): Collection;

    public function getRecentAppointments(int $limit = 5): Collection;

    public function countByStatus(AppointmentStatus $status): int;

    public function findWithDetails(int|string $id): ?Appointment;
}
