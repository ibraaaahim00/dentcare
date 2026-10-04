<?php

namespace App\Http\Controllers;

use App\Models\WorkingHour;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        protected DoctorRepositoryInterface $doctorRepository
    ) {}

    public function __invoke(): View
    {
        $doctors = $this->doctorRepository->getActiveDoctors();
        $workingHours = WorkingHour::orderBy('day_of_week')->get();

        return view('pages.about', compact('doctors', 'workingHours'));
    }
}
