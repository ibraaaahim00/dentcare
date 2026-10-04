<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MedicalRecordRepositoryInterface extends BaseRepositoryInterface
{
    public function getForPatient(int $patientId, int $perPage = 15): LengthAwarePaginator;

    public function getForDoctor(int $doctorId, int $perPage = 15): LengthAwarePaginator;

    public function getAllPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;
}
