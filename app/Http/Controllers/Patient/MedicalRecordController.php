<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected MedicalRecordRepositoryInterface $medicalRecordRepository
    ) {}

    public function index(Request $request): View
    {
        $records = $this->medicalRecordRepository->getForPatient($request->user()->id, 10);

        return view('patient.medical-records.index', compact('records'));
    }

    public function show(MedicalRecord $medicalRecord): View
    {
        $this->authorize('view', $medicalRecord);

        $medicalRecord->load(['doctor.user', 'appointment.service']);

        return view('patient.medical-records.show', compact('medicalRecord'));
    }
}
