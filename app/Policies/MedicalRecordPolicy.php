<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;

class MedicalRecordPolicy
{
    public function view(User $user, MedicalRecord $record): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isDoctor() && $user->doctor && $record->doctor_id === $user->doctor->id) {
            return true;
        }

        return $user->isPatient() && $record->patient_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isDoctor();
    }

    public function update(User $user, MedicalRecord $record): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isDoctor() && $user->doctor && $record->doctor_id === $user->doctor->id;
    }

    public function delete(User $user, MedicalRecord $record): bool
    {
        return $user->isAdmin();
    }
}
