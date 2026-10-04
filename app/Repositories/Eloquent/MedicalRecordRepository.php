<?php

namespace App\Repositories\Eloquent;

use App\Models\MedicalRecord;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MedicalRecordRepository extends BaseRepository implements MedicalRecordRepositoryInterface
{
    public function __construct(MedicalRecord $model)
    {
        parent::__construct($model);
    }

    public function getForPatient(int $patientId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->where('patient_id', $patientId)
            ->with(['doctor.user', 'appointment.service'])
            ->latest('treatment_date')
            ->paginate($perPage);
    }

    public function getForDoctor(int $doctorId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->where('doctor_id', $doctorId)
            ->with(['patient', 'appointment.service'])
            ->latest('treatment_date')
            ->paginate($perPage);
    }

    public function getAllPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['patient', 'doctor.user', 'appointment.service']);

        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('diagnosis', 'like', "%{$search}%")
                ->orWhere('treatment', 'like', "%{$search}%");
        }

        return $query->latest('treatment_date')->paginate($perPage);
    }
}
